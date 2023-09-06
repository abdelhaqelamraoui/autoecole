

document.body.onload = loadCandidatInformation


const candidatId = localStorage.getItem('consulter-candidat-id')

const list = document.getElementById("dates-seances-pratiques")
const avance = document.getElementById("avance")




function loadCandidatInformation() { 

  
  if(candidatId == null) {
    window.alert('Veuillez selectionner un candidat dans la list')
    // close this page and back to the previous one (the list of candidats)
    window.open('candidats.html')
    return
  }

  renderCandidatInformation(fetchCandidatAllInformation(candidatId))


}





function renderCandidatInformation(promise) {
  promise.then(data => {

    // console.log(data);

    const categorie = data["categorie"]

    getPrixCategorie(categorie)
    /* 
      TODO : how to get this data without using localstorage as midlle way ?
    */
    const prixCategorie = parseInt(localStorage.getItem('prix-categorie'))

    const avance = data["avance"]
    const seances = data["seancesPratiques"]

    document.getElementById('nom-prenom').textContent = `${data["nom"]} ${data["prenom"]}` 
    document.getElementById('cin').textContent = `${data["cin"]}` 
    document.getElementById('telephone').textContent = `${data["telephone"]}` 
    document.getElementById('avance').textContent = `${avance}` 
    document.getElementById('categorie').textContent = `${categorie}` 
    /* 
      TODO
      Need to get the category and then extrac its price to do the
      calculations of the rest
    */
    document.getElementById('reste').textContent = prixCategorie - parseInt(avance)
    
    document.getElementById('nombre-seances').textContent = seances.length
    document.getElementById('date-inscription').textContent = `${data["dateInscription"]}` 
    list.innerHTML = ''
    for (let i = 0; i < seances.length; i++) {
      const seance = seances[i];
      const li = document.createElement("li")
      li.classList = "list-group-item"
      li.innerHTML = `${seance["date_seance"]}`
      list.appendChild(li)
      
    }

  })
}






function getPrixCategorie(libelle) {
  
  return fetch(`../app/api.php/categorie?libelle=${libelle}`)
  .then(response => {
    if(! response.ok) {
      throw new Error("Cannot fetch the categorie from the server")
    }
    return response.json()
  }).then(data => {
    localStorage.setItem('prix-categorie', data.prix)
  })

}




function fetchCandidatAllInformation(id) {

  return fetch(`../app/api.php/candidat?id=${id}`).then(response => {
    
    if(! response.ok) {
      throw new Error("Cannot fetch data from the server")
    }
    return response.json()
  }).then(data => {

    const cat = data["categorie"];
    fetch(`../app/api.php/categories?libelle=${cat}`)
    .then(response => {
      if(! response.ok) {
        throw new Error("Cannot fetch the categorie from the server")
      }
      return response.json();
    }).then(data => {
      localStorage.setItem('max-nbr-seances', data["nombreSeancesPratiques"])
    })

    return data
  })
}




/******************************************************************** 
  Supprimer
********************************************************************/


document.getElementById('supprimer').addEventListener('click', e => {

  const formData = new FormData()
  formData.append('delete', 'delete')
  formData.append('id', candidatId)
  fetch('../app/', {method: 'POST', body: formData}).then(response => {
    if(! response.ok) {
      window.alert("Erreur: Candidat n'est pas supprimé !")
      throw new Error('Cannot delete this candidat')
    } else {
      window.alert("Candidat est pas supprimé !")
      window.open('candidats.html', '_self')
    }
  })
})

/********************************************************************
*********************************************************************/




/******************************************************************** 
  marquer un seance
********************************************************************/


document.getElementById('marquer-seance').addEventListener('click', e => {

  const nbrSeanceTd = document.getElementById('nombre-seances')
  const nbrSeance = parseInt(nbrSeanceTd.textContent)
  const maxNbrSeances = parseInt(localStorage.getItem('max-nbr-seances'))

  console.log(nbrSeance, maxNbrSeances);

  if(nbrSeance >= maxNbrSeances) {
    window.alert('Le max de seances est atteint !')
    return
  }

  const formData = new FormData()

  formData.append('marquer', 'marquer_seance')
  formData.append('id', candidatId)

  if(window.confirm('Marquer la seance ?')) {
    
    fetch('../app/', { method: 'POST', body: formData}).then(response => {
      nbrSeanceTd.textContent = nbrSeance + 1
    })

    const li = document.createElement("li")
    li.classList = "list-group-item"
    const date = new Date()
    let day = (date.getDate()).toString()
    let month = (date.getUTCMonth() + 1).toString()
    let year = date.getUTCFullYear()
    day = day.length == 1 ? '0' + day : day
    month = month.length == 1 ? '0' + month : month
    const str = `${year}-${month}-${day}`
    li.innerHTML = str
    list.appendChild(li)

  }
})

/********************************************************************
*********************************************************************/


/******************************************************************** 
  ajouter une avance
********************************************************************/
document.getElementById('ajouter-avance').addEventListener('click', e => {

  const montant = parseInt(window.prompt('Entrez le montant'))
  const avanceActuelle = parseInt(avance.textContent)
  const formData = new FormData()

  formData.append('ajouter-avance', 'value')
  formData.append('id', candidatId)
  formData.append('montant', montant)
  fetch('../app/', {method: 'POST', body: formData}).then(response => {
    if(response.ok) {
      avance.textContent = avanceActuelle + montant
    }
  })


})
/********************************************************************
*********************************************************************/
