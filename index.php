<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nebroc's Totk Benchmarks</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h2>Nebroc's Totk Benchmarks</h2>

<!-- Calls the php that extract things from the JSON -->
<?php include 'load_data.php'; ?> 

<form>
    <label for="gpu-filter">GPU:</label>
    <select id="gpu-filter">
        <option value="">All</option>
        <?php
        //be ready, the following lines are ugly
        //but they avoid duplicate filters
        $uniqueGPUs = array();
        foreach ($jsonObj as $userData) {
            $gpu = $userData->gpu;
            if (!in_array($gpu, $uniqueGPUs)) {
                $uniqueGPUs[] = $gpu;
                echo '<option value="' . $gpu . '">' . $gpu . '</option>';
            }
        }
        ?>
    </select>

    <label for="cpu-filter">CPU:</label>
<select id="cpu-filter">
    <option value="">All</option>
    <?php
    $uniqueCPUs = array();
    foreach ($jsonObj as $userData) {
        $cpu = $userData->cpu;
        if (!in_array($cpu, $uniqueCPUs)) {
            $uniqueCPUs[] = $cpu;
            echo '<option value="' . $cpu . '">' . $cpu . '</option>';
        }
    }
    ?>
</select>

<label for="emulator-filter">Emulator:</label>
<select id="emulator-filter">
    <option value="">All</option>
    <?php
    $uniqueEmulators = array();
    foreach ($jsonObj as $userData) {
        $emulator = $userData->emulator;
        if (!in_array($emulator, $uniqueEmulators)) {
            $uniqueEmulators[] = $emulator;
            echo '<option value="' . $emulator . '">' . $emulator . '</option>';
        }
    }
    ?>
</select>

<label for="location-filter">Location:</label>
<select id="location-filter">
    <option value="">All</option>
    <?php
    $uniqueLocations = array();
    foreach ($jsonObj as $userData) {
        $location = $userData->location;
        if (!in_array($location, $uniqueLocations)) {
            $uniqueLocations[] = $location;
            echo '<option value="' . $location . '">' . $location . '</option>';
        }
    }
    ?>
</select>

</form>

<!-- TABLEAU -->
<table id="comparison-table">
    <thead>
        <tr>
            <th>GPU</th>
            <th>CPU</th>
            <th>Emulator</th>
            <th>Location</th>
            <th>Benchmark Infos</th>
            <th>User Notes</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($jsonObj as $userData): ?>
                <tr>
                    <td><?php echo $userData->gpu; ?></td>
                    <td><?php echo $userData->cpu; ?></td> 
                    <td><?php echo $userData->emulator; ?></td>
                    <td><?php echo $userData->location; ?></td>
                    <td><?php echo nl2br($userData->benchmark_info); ?></td>
                    <td><?php echo $userData->user_notes; ?></td>
                </tr>
            <?php endforeach; ?>
    </tbody>
</table>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const gpuFilter = document.getElementById('gpu-filter');
    const cpuFilter = document.getElementById('cpu-filter');
    const emulatorFilter = document.getElementById('emulator-filter');
    const locationFilter = document.getElementById('location-filter');
    const tableRows = document.querySelectorAll('#comparison-table tbody tr');

    function filterTable() {
    const selectedGPU = gpuFilter.value;
    const selectedCPU = cpuFilter.value;
    const selectedEmulator = emulatorFilter.value;
    const selectedLocation = locationFilter.value;

    tableRows.forEach(row => {
        row.style.display = ''; // Toujours afficher toutes les lignes par défaut
        const gpuCell = row.querySelector('td:nth-child(1)').textContent;
        const cpuCell = row.querySelector('td:nth-child(2)').textContent;
        const emulatorCell = row.querySelector('td:nth-child(3)').textContent;
        const locationCell = row.querySelector('td:nth-child(4)').textContent.trim();

        if (
            (selectedGPU === '' || gpuCell === selectedGPU) &&
            (selectedCPU === '' || cpuCell === selectedCPU) &&
            (selectedEmulator === '' || emulatorCell === selectedEmulator) &&
            (selectedLocation === '' || locationCell === selectedLocation)
        ) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}



    gpuFilter.addEventListener('change', filterTable);
    cpuFilter.addEventListener('change', filterTable);
    emulatorFilter.addEventListener('change', filterTable);
    locationFilter.addEventListener('change', filterTable);

    // Initial filter call to ensure correct display on page load (I've seen that on internet)
    filterTable();
});

</script>

</body>
</html>
