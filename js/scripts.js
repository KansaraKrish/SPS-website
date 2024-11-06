document.querySelectorAll("#cpu-brand, #gpu-brand, #ram, #storage").forEach(select => {
    select.addEventListener("change", updateBuildPreview);
});

function updateBuildPreview() {
    alert("script called");
    const cpuBrand = document.getElementById("cpu-brand").value; // Get the selected CPU brand
    const gpuBrand = document.getElementById("gpu-brand").value; // Get the selected GPU brand
    const ramBrand = document.getElementById("ram-brand").value; // Get the selected RAM brand
    const primaryStorageBrand = document.getElementById("primary-storage-brand").value; // Get the selected primary storage brand
    const secondaryStorageBrand = document.getElementById("secondary-storage-brand").value; // Get the selected secondary storage brand

    // Determine the image source based on the CPU brand
    let imageSrc = '';
    if (cpuBrand === 'amd') {
        imageSrc = 'images/amd.jpg'; // Path for AMD image
    } else if (cpuBrand === 'intel') {
        imageSrc = 'images/intel.jpg'; // Path for Intel image
    } else {
        imageSrc = 'images/default-build.jpeg'; // Default image if no valid CPU brand is selected
    }

    // Update the image source
    document.getElementById("build-image").src = imageSrc;

    // Update the summary with selected components
    document.getElementById("build-summary").innerText = 
        `CPU: ${cpuBrand}, GPU: ${gpuBrand}, RAM: ${ramBrand}, Primary Storage: ${primaryStorageBrand}, Secondary Storage: ${secondaryStorageBrand}`;
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

    localStorage.setItem('customBuild', JSON.stringify(build));

    alert('Build saved successfully!');
}
