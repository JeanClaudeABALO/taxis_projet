var ajoutbtn = document.querySelector(".ouvreModal");
var ajoutModal = document.querySelector(".ajoutModal");
var ajoutModalContent = document.querySelector(".ajoutModal-content");
var closebtn = document.querySelector(".close");

if (ajoutbtn) {
    ajoutbtn.addEventListener("click", ()=>{
        var lesInput = document.querySelector(".formemaj").getElementsByTagName("input");

        var lesOptions = document.querySelector(".formemaj").getElementsByTagName("select")[0].getElementsByTagName("option");
        var laForme = document.querySelector(".formemaj");
        laForme.setAttribute("action", "/assets/includes/addoperateur.php")

        var titre = document.querySelector(".formulaire").getElementsByTagName("h3")[0];

        titre.innerText = "Ajouter operateur";
        lesInput[0].setAttribute("value", "");
        lesInput[1].setAttribute("value", "");
        lesInput[2].setAttribute("value", "");
        lesInput[3].setAttribute("value", "");
        lesOptions[0].removeAttribute("selected");
        lesOptions[1].removeAttribute("selected");
        lesInput[4].setAttribute("value", "Ajouter L'Operateur");
        lesInput[5].setAttribute("value", "Nétoyer les champs");
        lesInput[5].removeEventListener("click", closeModaleDid);

        openModalDid();
    });
}

function openModalDid() {    
    ajoutModal.style.display = "block";
    infoPlus.style.display = "none";
    imageFormulaire.style.display = "grid";
    ajoutModal.scrollTop = 0;
}
function openModalDid2() {    
    ajoutModal.style.display = "block";
    imageFormulaire.style.display = "none";
    infoPlus.style.display = "block";
    ajoutModal.scrollTop = 0;
}

if (closebtn) {
    closebtn.addEventListener("click", closeModaleDid);
}

if (ajoutModal) {
    ajoutModal.addEventListener("click", closeModaleDid);
}

function closeModaleDid(params) {
    ajoutModal.style.display = "none";
    imageFormulaire.style.display = "none";
    infoPlus.style.display = "none";
}

if (ajoutModalContent) {
    ajoutModalContent.addEventListener("click", stopPropagation);
}
function stopPropagation(e){
    e.stopPropagation();
}