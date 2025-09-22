// public/js/upload.js
document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("uploadForm");
    const fileInput = document.getElementById("fileInput");
    const progressBar = document.getElementById("progressBar");
    const status = document.getElementById("status");
    const baseUrl = window.location.origin + "/mini-php-framework/public";

    form.addEventListener("submit", async (e) => {
        e.preventDefault();
        const file = fileInput.files[0];

        if (!file) {
            alert("Veuillez choisir un fichier !");
            return;
        }

        if (file.size <= 2 * 1024 * 1024) {
            uploadSimple(file);
        } else {
            uploadChunked(file);
        }
    });

    function uploadSimple(file) {
        let formData = new FormData();
        formData.append("avatar", file);
        formData.append("nom", "Doe");
        formData.append("prenom", "John");
        formData.append("email", "john.doe@example.com");
        formData.append("password", "123456");

        let xhr = new XMLHttpRequest();
        xhr.open("POST", baseUrl + "/sinscrire");
        xhr.upload.onprogress = function(e) {
            if (e.lengthComputable) {
                progressBar.value = (e.loaded / e.total) * 100;
            }
        };

        xhr.onload = function() {
            status.innerText = xhr.responseText;
        };

        xhr.send(formData);
    }

    async function uploadChunked(file) {
        const chunkSize = 1024 * 512;
        const totalChunks = Math.ceil(file.size / chunkSize);
        const identifier = file.name + "-" + Date.now();
        const inputName = fileInput.name; // 👈 récupère "avatar" ou autre

        for (let i = 0; i < totalChunks; i++) {
            const chunk = file.slice(i * chunkSize, (i + 1) * chunkSize);

            let formData = new FormData();
            formData.append(inputName, chunk); // 👈 maintenant dynamique
            formData.append("identifier", identifier);
            formData.append("chunkIndex", i);
            formData.append("totalChunks", totalChunks);
            formData.append("originalName", file.name);

            await fetch(baseUrl + "/upload/chunk", { method: "POST", body: formData })
                .then(async response => {
                    if (!response.ok) {
                        let error = await response.text();
                        throw new Error(error);
                    }
                    return response.json();
                })
                .then(data => {
                    //console.log("Chunk uploaded:", data);
                })
                .catch(err => {
                    console.error("Upload failed:", err.message);
                    status.innerText = "Erreur: " + err.message;
                }
            );

            let percent = Math.round(((i + 1) / totalChunks) * 100);
            progressBar.value = percent;
            status.innerText = `Upload en cours... ${percent}%`;
        }

        status.innerText = "Upload terminé 🎉";
    }
});
