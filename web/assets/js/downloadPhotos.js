import axios from 'axios';

const downloadPhotosBtn = document.querySelector('.actionDownloadPhotos');

if (downloadPhotosBtn) {
    const formData = new FormData();
    formData.set('id', 2);

    downloadPhotosBtn.addEventListener('click', () => {
        axios.post('/api/portfolio/download', formData, {
            responseType: 'blob'
        })
            .then(response => {
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', 'my_archive.zip');
                document.body.appendChild(link);
                link.click();
                link.remove();
            })
            .catch(error => {
                alert('Error downloading photos!');
            });
    });
}
