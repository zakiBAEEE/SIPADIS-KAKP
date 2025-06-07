document.addEventListener('DOMContentLoaded', function () {
    const dropArea = document.getElementById('drop-area');
    const fileInput = document.getElementById('fileInput');
    const dropText = document.getElementById('drop-text');
  
    if (!dropArea || !fileInput || !dropText) return;
  
    fileInput.addEventListener('change', function () {
      if (fileInput.files.length > 0) {
        dropText.textContent = fileInput.files[0].name;
      } else {
        dropText.textContent = 'Klik atau tarik file ke sini';
      }
    });
  
    ['dragenter', 'dragover'].forEach(eventName => {
      dropArea.addEventListener(eventName, e => {
        e.preventDefault();
        dropArea.classList.add('border-blue-500', 'bg-blue-50');
      });
    });
  
    ['dragleave', 'drop'].forEach(eventName => {
      dropArea.addEventListener(eventName, e => {
        e.preventDefault();
        dropArea.classList.remove('border-blue-500', 'bg-blue-50');
      });
    });
  
    dropArea.addEventListener('drop', e => {
      if (e.dataTransfer.files.length > 0) {
        fileInput.files = e.dataTransfer.files;
        dropText.textContent = e.dataTransfer.files[0].name;
      }
    });
  });
  