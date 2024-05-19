var champDroit = document.querySelector("#droit");
var date = new Date();
var ouvreModal = document.querySelector(".ouvreModal");
var laforme = document.querySelector(".laforme");

//insersion de la date sur la page de course
if (champDroit) {
    champDroit.innerHTML = champDroit.textContent + date.getFullYear();
}

// dynamisation du formulaire d'ajout de course
if (ouvreModal) {

    var closebtn = document.querySelector(".close");
    var courseModal = document.querySelector(".courseModal");
    var courseModalContent = document.querySelector(".courseModal-content");
    

    ouvreModal.addEventListener("click", ()=>{
        var modalTitle = document.querySelector(".modalTitle");
        var lesInputs = courseModalContent.getElementsByTagName("input");

        laforme.setAttribute("action", "/assets/includes/addCourseAsOperateur.php");
        modalTitle.innerText = " Renseigner une course ! ";
        lesInputs[0].setAttribute("value", "");
        lesInputs[1].setAttribute("value", "");
        lesInputs[2].setAttribute("value", "");
        lesInputs[3].setAttribute("value", "");
        lesInputs[4].setAttribute("value", "Annuler");
        lesInputs[5].setAttribute("value", "Enrégistrer");
        
        openModalDid();
    });
    closebtn.addEventListener("click", closeModaleDid);
    courseModal.addEventListener("click", closeModaleDid);
    courseModalContent.addEventListener("click", stopPropagation);


    function openModalDid() {
        courseModal.style.display = "block";
    }

    function closeModaleDid() {
        courseModal.style.display = "none";
    }

}

function stopPropagation(e){
    e.stopPropagation();
}