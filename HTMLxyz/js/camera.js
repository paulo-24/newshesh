document.addEventListener("DOMContentLoaded", function() {
    const video = document.querySelector(".video");
    const cameraButton = document.querySelector(".camera-button");
    const canvas = document.querySelector(".canvas");

    if (video) {
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => {
                if (video) {
                    video.srcObject = stream;
                    video.play();
                }
            })
            .catch(error => {
                console.error("Error accessing the camera:", error);
            });
    }

    if (cameraButton) {
        cameraButton.addEventListener("click", () => {
            if (canvas) {
                canvas.getContext("2d").drawImage(video, 0, 0, canvas.width, canvas.height);
                const image_data_url = canvas.toDataURL("image/jpeg");

                // Send the image_data_url to the server via AJAX
                $.ajax({
                    url: 'save_image.php',
                    type: 'POST',
                    data: {
                        image_data: image_data_url
                    },
                    success: function(response) {
                        console.log("Image saved on the server:", response);
                        // Automatically download the image after saving
                        window.location.href = response;
                    },
                    error: function(xhr, status, error) {
                        console.error("Error saving image:", error);
                    }
                });
            }
        });
    }
});
