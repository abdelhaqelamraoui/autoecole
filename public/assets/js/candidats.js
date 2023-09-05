


document.body.onload = loadCandidats

const searchPattern = document.getElementById('pattern')
const btnRechercher = document.getElementById('search')
const tbody = document.getElementById('list-candidat')

searchPattern.addEventListener('input', rechercher)
btnRechercher.addEventListener('click', rechercher)




function loadCandidats() {
  /* 
    Fetch all candidats data from the server and render it
    (call the function bellow)
  */
 tbody.innerHTML = ''
//  TODO :  add the adequat URL
// console.log(fetchDataFromServer('../app/api.php'));
 renderJsonData(fetchDataFromServer('../app/api.php'))
 
}





function renderJsonData(promise) {
  promise.then(jsonData => {
    const candidats = jsonData
    for (let i = 0; i < candidats.length; i++) {
      const candidat = candidats[i];
      const tr = document.createElement('tr')
      tr.className = "align-middle"
      tr.id = candidat["id"]
      // TODO : readapt this function to the sent json data from the server
      tr.innerHTML =  `
        <td class="fw-bold text-center p-2">${i+1}</td>
        <td class="p-2" onclick="consulter(this)">${candidat["nom"] + candidat["prenom"]}</td>
        <td class="text-center p-2">${candidat["categorie"]}</td>
        <td class="text-center p-2">${candidat["nombre_seances"]}</td>
        <td class="text-center p-2">
          <button class="btn btn-warning btn-sm" onclick="marquerSeancePratique(this)">Marquer</button>
        </td> `
        tbody.appendChild(tr)
    }
  })
}





function fetchDataFromServer(url)  {
  return fetch(url, {method: "GET"})
  .then(response => {
    if(! response.ok) {
      throw new Error("Cannot fetch data from the server")
    }
    return response.json()
  })
}




function rechercher() {
  // live search  
  const pattern = searchPattern.value.trim()

  if(pattern.length <= 0) {
    loadCandidats()
    return
  }

  tbody.innerHTML = ''
  const promiseData = fetchDataFromServer(`../app/api.php/candidats?pattern=${pattern}`)
  renderJsonData(promiseData)

}



function marquerSeancePratique(buttonElement) {
  /* 
    marquer un seance pour un candidat, apres une confirmation.
    On modifie dand la DB et dans la page aussi.
  */

  // TODO : [X] edit in html instead of refreshing the page
  const nbrSeanceTd = buttonElement.parentElement.previousElementSibling
  const nbrSeance = parseInt(nbrSeanceTd.textContent)
 
  const candidatId = buttonElement.parentElement.parentElement.id
  const formData = new FormData()

  formData.append('marquer', 'marquer_seance')
  formData.append('id', candidatId)

  if(window.confirm('Marquer la seance ?')) {
    
    fetch('../app/', { method: 'POST', body: formData}).then(response => {
      nbrSeanceTd.textContent = nbrSeance + 1
    })

  }


}





function consulter(tdElement) {
  /* 
    View a candidat after clicking on his name in the table
  */

    const candidatId = tdElement.parentElement.id
    localStorage.setItem('consulter-candidat-id', candidatId)
    window.open('consulter.html', '_self')
}