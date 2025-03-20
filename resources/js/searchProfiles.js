// window.onclick = function (event) {
//     const searchModal = document.getElementById('search-modal');
//     if(event.target === searchModal) {
//         searchModal.style.display = "none";
//     }
// }



document.addEventListener("DOMContentLoaded", function () { //se asculta doar dupa ce s-a incarcat complet dom-ul
    const searchInput = document.getElementById('searchBar');
    const profileResults = document.getElementById('profileResults');
    const resultsBox = document.getElementById('resultsBox');
    const noResults = document.createElement('span');
    const searchModal = document.getElementById('search-modal');
    noResults.classList.add('text-dark');
    noResults.style.fontSize = '16px';
    noResults.style.fontWeight = '500';
    noResults.textContent = 'No results found.';
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const query = searchInput.value;
            if(query.length === 0) {
                resultsBox.style.display = "none";
                searchModal.style.display = "none";
            }
            else {
                searchModal.style.display = "block";
                resultsBox.style.display = "block";
            }
            if(query.length > 0) {
                axios.get('/search?query=' + query)
                    .then(response => {
                        profileResults.innerHTML = ``;
                        const users = response.data;
                        if(users.length  === 0) {
                            profileResults.style.textAlign = 'center';
                            profileResults.append(noResults);
                        }
                        else {
                            if(profileResults.contains(noResults)) {
                                profileResults.removeChild(noResults);
                            }
                            profileResults.style.removeProperty('text-align');
                            const newResults = addNewResults(users);
                            profileResults.append(newResults);

                        }
                    })
                    .catch(error => {
                        console.error("Eroare", error);
                    })
            }
        });
    }
});

function addNewResults(users) {
    const newResults = document.createElement('div');
    for(const user of users) {
        const newResult = document.createElement('div');
        newResult.classList.add('search-result');
        newResult.innerHTML = `
                    <a href="/profile/${user.id}" class="text-decoration-none"
                        target="_blank">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center" style="line-height: 1.4;">
                                <div class="pl-3 pr-3">
                                    <img src="${user.profileImage}"
                                         class="w-100 rounded-circle"
                                         style="height: 44px; width: 44px" alt="user-image">
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="font-weight-bold text-dark"
                                          style="font-size: 14px;">
                                        ${user.username}
                                    </span>
                                    <span
                                        style="font-weight: 400; font-size: 14px; color: rgb(168, 168, 168);">
                                        <div class="d-flex">
                                            ${user.profile.title}
                                            <div class="pl-1 pr-1">•</div>
                                            ${user.followers} followers
                                        </div>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
    `;
        newResults.append(newResult);
    }
    return newResults;

}




