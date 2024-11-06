
function saveBuild() {
    const cpu = document.getElementById('cpu').value;
    const gpu = document.getElementById('gpu').value;
    const ram = document.getElementById('ram').value;
    const storage = document.getElementById('storage').value;

    const build = {
        cpu,
        gpu,
        ram,
        storage
    };

    localStorage.setItem('customBuild', JSON.stringify(build));

    alert('Build saved successfully!');
}

// window.addEventListener('beforeunload', function () {
//     fetch('logout.php', {
//         method: 'GET',
//         headers: {
//             'Content-Type': 'application/json'
//         }
//     });
// });
