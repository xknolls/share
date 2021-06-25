; (function () {
    'use strict';

    //on recupère tous les boutons supprimer et on les stock dans un tableau
    let supprBtn = document.querySelectorAll(".confirmDelete");

    //on boucle sur le tableau
    for (let i = 0; i < supprBtn.length; i++) {
        //evenement d'écoute sur le bouton suppr
        supprBtn[i].addEventListener('click', function (event) {
            //confirmation utilisateur pour la sécurité
            let isConfirmed = window.confirm('Voulez-vous vraiment supprimer ?');
            //si l'utilisateur annule, l'évènement s'annule
            if (isConfirmed === false) {
                event.preventDefault();
            }
        });
    }

    //on recupère les boutons modifier et on les stock dans un tableau
    let modifySubject = document.querySelectorAll(".modifySubject");

    //on boucle sur le tableau
    for (let i = 0; i < modifySubject.length; i++) {
        //evenement d'écoute sur le bouton suppr
        modifySubject[i].addEventListener('click', function (event) {
            //on prérempli le prompt avec le nom actuel.
            let newName = window.prompt('Modifiez le sujet :', modifySubject[i].getAttribute('data-subject'));
            //
        });
    }
})();