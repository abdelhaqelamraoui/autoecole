<?php

declare(strict_types=1);


namespace App\Providers;

use App\Classes\Candidat;
use App\Classes\CandidatInformations;
use App\Classes\Categorie;
use App\Classes\Seance;
use App\Database\MysqlDatabase;
use App\Exceptions\Database\ConnectionException;


class MysqlDataProvider extends DataProvider
{

  private ?MysqlDatabase $db = null;

  public function __construct()
  {
    try {

      $this->db = new MysqlDatabase();

    } catch (ConnectionException $e) {

      var_dump($e->getMessage());
      exit;

    } catch (\Throwable $th) {
      throw $th;
    }

  }





  /************************************************************************************/
  /********************************* Candidat management ******************************/
  /************************************************************************************/


  public function addCandidat(string $nom, string $prenom, string $cin, string $telephone, string $categorie, int $avance, string $dateInscription): bool
  {
    return $this->db->execute(
      'INSERT INTO candidat(nom, prenom, cin, telephone, categorie, avance, date_inscription) VALUES(?, ?, ?, ?, ?, ?, ?)',
      [$nom, $prenom, $cin, $telephone, $categorie, $avance, $dateInscription]
    );
  }


  public function updateCandidat(int $id, string $nom, string $prenom, string $cin, string $telephone, string $categorie, int $avance, string $dateInscription): bool
  {
    return $this->db->execute(
      'UPDATE candidat SET nom = ?, prenom = ?, cin = ?, telephone = ?, categorie = ?, avance = ?, date_inscription = ? WHERE id = ?',
      [$id, $nom, $prenom, $cin, $telephone, $categorie, $avance, $dateInscription]
    );
    ;
  }


  public function deleteCandidat(int $id): bool
  {
    return $this->db->execute('DELETE FROM candidat WHERE id = ?', [$id]);
  }


  public function getCandidatById(int $id): ?Candidat
  {
    $res = $this->db->query('SELECT * FROM candidat WHERE id = ?', [$id], \PDO::FETCH_CLASS, Candidat::class);
    return $res[0] ?? null;
  }



  public function getCandidatByCIN(string $cin): ?Candidat
  {
    $res =  $this->db->query(
      'SELECT * FROM candidat WHERE cin LIKE ?',
      ['%' . $cin . '%'],
      \PDO::FETCH_CLASS,
      Candidat::class
    );
    return $res[0] ?? null;
  }



  public function getCandidatsByNomPrenom(string $nomPrenom): array
  {
    return $this->db->query(
      'SELECT * FROM candidat WHERE CONCAT(nom, prenom) LIKE ?',
      ['%' . $nomPrenom . '%']
    );
  }


  public function getCandidatsByCategorie(string $categorie): array
  {
    return $this->db->query(
      'SELECT * FROM candidat WHERE categorie = ?',
      [$categorie]
    );
  }




  /**
   * @return array an array of Candidat
   */
  public function getAllCandidats(): array
  {
    return $this->db->query('SELECT * FROM candidat', null, \PDO::FETCH_CLASS, Candidat::class);
  }


  public function getCandidatInformations(int $id): ?CandidatInformations
  {
    $candidat = $this->getCandidatById($id);

    if (is_null($candidat)) {
      return null;
    }

    $candidatInformations = CandidatInformations::newCandidatInformation($candidat);

    $candidatInformations->seancesPratiques = $this->getCandidatSeances($id);

    return $candidatInformations;
  }


  /**
   * @return array an array of associative arrays
   */
  public function getAllCandidatsInfos(): array
  {
    $query = <<<TXT
      SELECT c.id, c.nom, c.prenom, c.cin, c.telephone, c.categorie,
              c.avance, c.date_inscription, COUNT(s.id) AS nombre_seances
       FROM candidat c 
       LEFT JOIN seance s 
       ON c.id = s.candidat
       GROUP BY c.id
    TXT;
    return $this->db->query($query, null, \PDO::FETCH_ASSOC);
  }


  
  /**
   * @return array an array of associative arrays
   */
  public function getCandidatSeances(int $id): array
  {
    return $this->db->query(
      'SELECT date_seance from seance WHERE candidat = ? ORDER by date_seance',
      [$id],
      \PDO::FETCH_ASSOC
    );
  }


  
  /**
   * @return array an array of Candidat
   */
  public function getCandidatsByPattern(string $pattern): array
  {
    return $this->db->query(
      'SELECT * FROM candidat WHERE cin LIKE ? OR CONCAT(NOM, PRENOM) LIKE ?',
      ['%' . $pattern . '%', '%' . $pattern . '%'],
      \PDO::FETCH_CLASS,
      Candidat::class
    );
  }

  
  /**
   * @return array an array of arrays
   */
  public function getCandidatsInformationByPattern(string $pattern): array
  {
    $query = <<<TXT
      SELECT c.id, c.nom, c.prenom, c.cin, c.telephone, c.categorie,
              c.avance, c.date_inscription, COUNT(s.id) AS nombre_seances
       FROM candidat c 
       LEFT JOIN seance s 
       ON c.id = s.candidat
       WHERE cin LIKE ? OR CONCAT(NOM, PRENOM) LIKE ?
       GROUP BY c.id
    TXT;
    return $this->db->query($query, ['%' . $pattern . '%', '%' . $pattern . '%']);
  }

  // TODO : not tested yet
  public function marquerSeancePratique(string $id): bool
  {
    return $this->db->execute(
      'INSERT INTO seance(candidat, date_seance) values(?, CURDATE())',
      [$id]
    );
  }

  public function ajouterAvance(int $id, int $monatant): bool
  {
    return $this->db->execute(
      'UPDATE candidat SET avance = avance + ? WHERE id = ?',
      [$monatant, $id]
    );
  }



  /************************************************************************************/
  /********************************* Categorie management *****************************/
  /************************************************************************************/

  public function addCategorie(string $libelle, int $prix, $nombreSeancesPratiques): bool
  {
    return $this->db->execute(
      'INSERT INTO categorie(libelle, prix, nombre_seances_pratiques) VALUES(?, ?, ?)',
      [$libelle, $prix, $nombreSeancesPratiques]
    );
  }

  public function updateCategorie(int $id, string $libelle, int $prix, $nombreSeancesPratiques): bool
  {
    return
      true;
  }

  public function deleteCategorie(int $id): bool
  {
    return $this->db->execute('DELETE FROM categorie WHERE id = ?', [$id]);
  }

  public function getCategorieById(int $id): ?Categorie
  {
    $res = $this->db->query(
      'SELECT * FROM categorie WHERE id = ?',
      [$id],
      \PDO::FETCH_CLASS,
      Categorie::class
    );
    return $res[0] ?? null;
  }

  public function getCategorieByLibelle(string $libelle): ?Categorie
  {
    $res = $this->db->query(
      'SELECT * FROM categorie WHERE libelle = ?',
      [$libelle],
      \PDO::FETCH_CLASS,
      Categorie::class
    );
    return $res[0] ?? null;
  }


  /**
   * @return array an array of Categorie
   */
  public function getAllCategories(): array
  {
    return $this->db->query(
      'SELECT * FROM categorie',
      null,
      \PDO::FETCH_CLASS,
      Categorie::class
    );
  }


  /************************************************************************************/
  /*********************************** Seance management ******************************/
  /************************************************************************************/

  public function addSeance(int $candidatId, string $dateSeance): bool
  {
    return $this->db->execute(
      'INSERT INTO seance(candidat, date_seance) VALUES(?, ?)',
      [$candidatId, $dateSeance]
    );
  }

  public function getSeance(int $id): ?Seance
  {
    $res = $this->db->query(
      'SELECT * FROM seance WHERE id = ?',
      [$id],
      \PDO::FETCH_CLASS,
      Seance::class
    );
    return $res[0] ?? null;
  }


    /**
   * @return array an array of Seances
   */
  public function getAllSeances(): array
  {
    return $this->db->query('SELECT * FROM seance', null, \PDO::FETCH_CLASS, Seance::class);
  }



  /**
   * @return array an array of Seance
   */
  public function getAllSeancesByCandidatId(int $candidatId): array
  {
    return $this->db->query(
      'SELECT * FROM seance WHERE candidat = ?',
      [$candidatId],
      \PDO::FETCH_CLASS,
      Seance::class
    );
  }





}