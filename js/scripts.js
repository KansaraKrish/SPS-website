function updateBuild() {
    const cpu = document.getElementById('cpu').value;
    const gpu = document.getElementById('gpu').value;
    const ram = document.getElementById('ram').value;
    const storage = document.getElementById('storage').value;

    const buildSummary = `CPU: ${cpu}<br>GPU: ${gpu}<br>RAM: ${ram}<br>Storage: ${storage}`;
    document.getElementById('build-summary').innerHTML = buildSummary;

    let buildImage = 'images/default-build.jpg'; // Default image
    if (cpu === 'Intel i9') {
        buildImage = 'images/intel-build.jpg';
    } else if (cpu === 'AMD Ryzen 9') {
        buildImage = 'images/amd-build.jpg';
    }

    document.getElementById('build-image').src = buildImage;
}

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

    // Save build to localStorage (can be extended to a backend save)
    localStorage.setItem('customBuild', JSON.stringify(build));

    alert('Build saved successfully!');
}
