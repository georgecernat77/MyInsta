window.likeComment = function (commentId) {
    axios.post('/likeComment/' + commentId)
        .then(response => {
            // this.status = !this.status;
            // verificam daca utilizatorul a dat like / unlike la comentariu
            const {attached, detached} = response.data; // aici se populeaza attached , dettached cu array-urile corespunzatoare din response.data
            const likeIcon = document.getElementById(`like-icon-${commentId}`);
            const liked = attached.includes(commentId);
            const unliked = detached.includes(commentId);
            if (liked) {
                likeIcon.src = '/storage/icons/heart-full.png';
            } else {
                likeIcon.src = '/storage/icons/heart-empty.png';
            }
            updateLikes(commentId);
        })
        .catch(errors => {
            console.error("Eroare", errors)
            if (errors.response.status === 401) {
                window.location = '/login';
            }
        })
}

function updateLikes(commentId) {
    const likesCountDiv = document.getElementById(`likes-count-${commentId}`)
    axios.get('/' + commentId + '/likes/')
        .then(response => {
            likesCountDiv.innerHTML = `${response.data} likes`;
        })
        .catch(errors => {
            if (errors.response.status === 401) {
                window.location.reload();
            }
        })
}

window.toggleOptions = function () {
    const modal = document.getElementById("options-modal");
    modal.style.display = (modal.style.display === "flex") ? "none" : "flex";
    window.addNoScroll();
}

window.onclick = function (event) {
    const modal = document.getElementById("options-modal");
    const editModal = document.getElementById("edit-modal");
    if (event.target === modal) {
        modal.style.display = "none";
        window.removeNoScroll();
    }
    if (event.target === editModal) {
        editModal.style.display = "none";
    }

}

window.toggleEditPost = function () {
    const modal = document.getElementById("edit-modal");
    const textarea = document.getElementById("caption-textarea");
    const charCount = document.getElementById("charCount");
    const errorField = document.getElementById("input-error");
    const initialValue = textarea.textContent.length;
    const saveButton = document.getElementById("save-caption");
    const maxLength = 250;
    if (initialValue > 0)
        charCount.textContent = `${initialValue}/${maxLength}`;
    textarea.addEventListener("input", function () {
        errorField.textContent = ``;
        if (textarea.value.length > 250) {
            textarea.value = textarea.value.slice(0, 250);
            errorField.textContent = `Ai atins limita maxima de caractere!`;
        }
        if (saveButton.hasAttribute("disabled")) {
            saveButton.removeAttribute("disabled");
        }
        charCount.textContent = `${textarea.value.length}/${maxLength}`;

    });

    // partea de salvare a caption-ului
    const editForm = document.getElementById("edit-caption-form");
    editForm.addEventListener("submit", function (event) {
        event.preventDefault();
        const postId = document.getElementById('post-id').value;
        const caption = document.getElementById('caption-textarea').value;
        const captionText = document.getElementById('post-caption');
        axios.post('/p/' + postId + '/update', {
            caption: caption
        })
            .then(response => {
                toggleOptions();
                if (response.status === 200) {
                    errorField.textContent = `Actualizat cu succes!`;
                    errorField.classList.add("text-success");
                    captionText.textContent = caption;
                }
            })
            .catch(error => {
                if (error.status === 304) {
                    errorField.textContent = `Descrierile sunt la fel!`;
                    errorField.classList.add("text-danger");
                } else {
                    errorField.textContent = `A aparut o eroare!`;
                    errorField.classList.add("text-danger");
                }
            })


    })

    modal.style.display = (modal.style.display === "flex") ? "none" : "flex";
}



window.toggleDeletePost = function () {
    const deleteModal = document.getElementById('delete-modal');
    deleteModal.style.display = (deleteModal.style.display === 'flex') ? 'none' : 'flex';
}

window.addNewComment = function (commentData, commentsContainer) {
    // se creeaza noul comentariu
    const newComment = document.createElement('div');
    newComment.classList.add('pfp-and-comment', 'd-flex');
    newComment.style.position = "relative";
    // se formeaza html-ul comentariului
    newComment.innerHTML = `
                    <div class="pr-3">
                        <a class="text-decoration-none" href="/profile/${commentData.user.id}">
                            <img src="${commentData.user.profileImage}" alt=""
                                 class="w-100 rounded-circle"
                                 style="max-width: 35px">
                        </a>
                    </div>
                    <div class="comment-and-like d-flex">
                        <div class="comment-and-date d-flex flex-column mb-3">
                            <div class="comment d-flex align-items-center">
                                    <span class="font-weight-bold">
                                    <a class="text-decoration-none" href="/profile/${commentData.user.id}">
                                        <span class="text-dark">${commentData.user.username}</span>
                                    </a>
                                    </span>
                                <div class="pl-1">${commentData.content}</div>
                            </div>
                            <div class="comment-date mt-1 d-flex"
                                 style="font-size: 12px; color: rgb(168,168,168,1); font-weight: 400">
                                now
                                <div class="likes-count ml-3 font-weight-bold"
                                     id="likes-count-${commentData.id}">
                                    0 likes
                                </div>
                            </div>
                        </div>
                        <button class="btn comment-like-btn" onclick="likeComment(${commentData.id})">
                                <img src="/storage/icons/heart-empty.png" class='comment-like-icon'
                                     id="like-icon-${commentData.id}"/>
                        </button>
                    </div>
                `;
    commentsContainer.prepend(newComment);
    document.getElementById('add-comment-content').value = '';
}

window.safeDeletePost = function () {
    const postId = document.getElementById('post-id').value;
    const succesModal = document.getElementById('succes-modal');
    const optionsModal = document.getElementById('options-modal');
    const deleteModal = document.getElementById('delete-modal');
    const succesMessage = document.querySelector('.succes-message');
    const checkmark = document.querySelector('.checkmark');
    axios.delete('/p/' + postId + '/delete')
        .then(response => {
            toggleOptions();
            toggleDeletePost();
            const reddirectUrl = response.redirect_url;
            if (response.status === 200) {
                succesModal.style.display = "flex";
                succesMessage.textContent = 'Postare stearsa cu succes!';
                setTimeout(() => {
                    succesModal.style.display = "none";
                    window.location.href = reddirectUrl;
                }, 2000);

            }
        })
        .catch(error => {
            checkmark.innerHTML = '&#10006';
            checkmark.style.color = 'rgb(237, 26, 43)';
            succesModal.style.display = "flex";
            succesMessage.textContent = 'Eroare!';
            console.log(error.response.data.message);
            setTimeout(() => {
                succesModal.style.display = "none";
                window.location.reload();
            }, 2000);

        });
}









