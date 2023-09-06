


const nom = document.getElementById('nom')
const prenom = document.getElementById('prenom')
const cin = document.getElementById('cin')
const telephone = document.getElementById('telephone')
const categorie = document.getElementById('categorie')
const avance = document.getElementById('avance')
const nombreSeancesPratiques = document.getElementById('nombre-seances')
const dateInscription = document.getElementById('date-inscription')

/***********************************************************************
 * Main
 ***********************************************************************/
const currDate = new Date().toISOString().split('T')[0]
dateInscription.value = currDate

loadCategories();

document.getElementById('add').addEventListener('click', addCandidat)

/***********************************************************************
***********************************************************************/




function loadCategories() {
  fetch('../app/api.php/categories').then(response => {
    if(! response.ok) {
      throw new Error("Error occured while fetching categories from the server")
    }
    return response.json()
  }).then(data => {
    for(categ of data) {
      const libelle = categ["libelle"]
      const option = document.createElement('option')
      option.value = libelle
      option.textContent = libelle
      if(libelle == 'B') {
        option.setAttribute('selected', true)
      }
      categorie.appendChild(option)
    }
  })
}


function addCandidat() {

  // console.log('clicked');

  const formData = new FormData()
  formData.append('add', 'add')
  formData.append('nom', nom.value.trim())
  formData.append('prenom', prenom.value.trim())
  formData.append('cin', cin.value.trim())
  formData.append('telephone', telephone.value.trim())
  formData.append('categorie', categorie.value)
  formData.append('avance', avance.value.trim())
  // formData.append('nombre-seances', nombreSeancesPratiques.value)
  formData.append('date-inscription', dateInscription.value)

  fetch('../app/', {method: 'POST', body: formData}).then(response => {
    if(! response.ok) {
      throw new Error('Error occured while adding a new candidat')
    }
    // window.alert('Candidat bien ajouté')
    // window.open('candidats.html', '_self')
    return response.text()
  }).then(data => {
    console.log(data);
  })
}