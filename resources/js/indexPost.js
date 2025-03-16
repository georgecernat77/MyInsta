import { createApp } from "vue";
import LikeWindow from "./components/LikeWindow.vue";
import FollowButton from "./components/FollowButton.vue";


window.onclick = function (event) {
    const postModal = document.getElementById('postModal');
    const shareModal = document.getElementById('shareModal');
    // verifica dacă utilizatorul a dat click direct pe div-ul principal al modalului (nu pe continutul sau)
    if (event.target === postModal) {
        postModal.style.display = "none";
        window.removeNoScroll()
    }
    if (event.target === shareModal) {
        shareModal.style.display = "none";
        window.removeNoScroll();
    }
}

window.togglePostModal = function (postId) {
    axios.get('/p/' + postId)
        .then(response => {
            const postModal = document.getElementById('postModal');
            postModal.style.display = (postModal.style.display === "flex") ? "none" : "flex";
            document.getElementById('modal-body').innerHTML = response.data;
            // se creeaza o noua instanta vue si se adauga cele 2 componente
            // se asociaza noua instanta vue la div-ul modal-body
            setTimeout(() => {
                const modalApp = createApp({});
                modalApp.component('like-window', LikeWindow);
                modalApp.component('follow-button', FollowButton);
                modalApp.mount('#modal-body');
            }, 10);
            syncHeight();
            window.addNoScroll();
        })
        .catch(error => {
            console.error('Eroare', error);
        })


}


    // adaugarea unui comentariu real time

    document.addEventListener('submit',  function(event) {
        if (event.target && event.target.matches('#add-comment-form')) {
            event.preventDefault(); // Oprire submit clasic
            console.log("salut12345");
            const commentContent = document.getElementById('add-comment-content').value;
            const postId = document.getElementById('post-id').value;

            axios.post('/comment/' + postId, {
                content: commentContent
            })
                .then(response => {
                    if (response.status === 200) {
                        const commentData = response.data.comment;
                        const commentsContainer = document.getElementById('comments-section');
                        window.addNewComment(commentData, commentsContainer);
                    }
                })
                .catch(error => {
                    console.error("Eroare", error);
                })


        }
    });


function syncHeight() {
    const imgContainer = document.querySelector('.col-8 img');
    const commentsContainer = document.querySelector('.right-div');

    if (imgContainer && commentsContainer) {
        if(window.innerWidth > 1500){
            commentsContainer.style.height = `${imgContainer.clientHeight - 10}px`;
        }
        else if (window.innerWidth > 1000) {
            commentsContainer.style.height = `${imgContainer.clientHeight - (window.innerWidth / 15)}px`;

        }
        else {
            commentsContainer.style.height = `${imgContainer.clientHeight}px`;
        }


    }
}

window.addNoScroll = function () {
    document.body.classList.add("no-scroll");
}

window.removeNoScroll = function () {
    document.body.classList.remove("no-scroll");
}

window.addEventListener("resize", syncHeight);

window.toggleShareModal = function (postId) {
    const shareModal = document.getElementById('shareModal');
    shareModal.style.display = (shareModal.style.display === "flex") ? "none" : "flex";
    const copyButton = document.querySelector(".copy-link-button");
    copyButton.addEventListener("click", function () {
       const appUrl = document.querySelector("meta[name='app-url']").getAttribute("content");
       const postUrl = appUrl + ':8000' + '/p/' + postId;
       navigator.clipboard.writeText(postUrl).then(() => {
           copyButton.textContent = "Link copied!"
           copyButton.setAttribute('disabled', 'true');
           setTimeout(() => {
               copyButton.textContent = "Copy link";
               copyButton.removeAttribute('disabled');
           }, 2000);
           window.addNoScroll();
       }).catch(err => {
           copyButton.textContent = "Error"
       });
    });
}

window.closeShareModal = function () {
    const shareModal = document.getElementById('shareModal');
    shareModal.style.display = (shareModal.style.display === "flex") ? "none" : "flex";
    window.removeNoScroll();
}
