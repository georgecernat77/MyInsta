window.likeComment = function(commentId) {
    axios.post('/likeComment/' + commentId)
        .then(response => {
            // this.status = !this.status;
            // verificam daca utilizatorul a dat like / unlike la comentariu
            const { attached, detached } = response.data; // aici se populeaza attached , dettached cu array-urile corespunzatoare din response.data
            const likeIcon = document.getElementById(`like-icon-${commentId}`);
            const liked = attached.includes(commentId);
            const unliked = detached.includes(commentId);
            if (liked) {
                likeIcon.src = '/storage/icons/heart-full.png';
            }
            else {
                likeIcon.src = '/storage/icons/heart-empty.png';
            }
            updateLikes(commentId);
        })
        .catch(errors => {
            if(errors.response.status === 401) {
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
            if(errors.response.status === 401) {
                window.location.reload();
            }
        })
}
