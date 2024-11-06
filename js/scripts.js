document.querySelectorAll("#cpu-brand, #gpu-brand").forEach(select => {
    select.addEventListener("change", updateBuildPreview);
});

function updateBuildPreview() {
    const cpuBrand = document.getElementById("cpu-brand").options[document.getElementById("cpu-brand").selectedIndex].text.toLowerCase();
    const gpuBrand = document.getElementById("gpu-brand").options[document.getElementById("gpu-brand").selectedIndex].text.toLowerCase();

    let imageSrc = `images/${cpuBrand}_${gpuBrand}.jpg`;
    document.getElementById("build-image").src = imageSrc;
    document.getElementById("build-summary").innerText = `CPU: ${cpuBrand}, GPU: ${gpuBrand}`;
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
