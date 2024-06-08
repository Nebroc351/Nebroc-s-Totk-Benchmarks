const gpu_list = [];
const cpu_list = [];
const emu_list = [];
const loc_list = [];

function HtmlGenerator() { 
    fetch("resources/data/database.json")
        .then(response => response.json())
        .then(jsonResponse => {

        $('#comparison-table tbody').empty(); //clear the table

        for (let i in jsonResponse) {
            const id = "tr" + i
            const current_gpu = jsonResponse[i]["gpu"]
            const current_cpu = jsonResponse[i]["cpu"]
            const current_emu = jsonResponse[i]["emulator"]
            const current_loc = jsonResponse[i]["location"]
            const current_bench = jsonResponse[i]["benchmark_info"]
            const current_user = jsonResponse[i]["user_notes"]

            //here we generate lines themselves
            $("tbody").append(`
            <tr id=${id}></tr>
            `)

            //and from there we actually put the stuff in those lines

            //for the tab
            //Note: had to put multiple if that way cause AND would not work
            if($("#gpu-filter option:selected").text() === current_gpu || 
            $("#gpu-filter option:selected").text() === "All" ) {

                if($("#cpu-filter option:selected").text() === current_cpu || 
                $("#cpu-filter option:selected").text() === "All" ) {
                    
                    if($("#emulator-filter option:selected").text() === current_emu || 
                    $("#emulator-filter option:selected").text() === "All" ) {

                        if($("#location-filter option:selected").text() === current_loc || 
                        $("#location-filter option:selected").text() === "All" ) {

                            $("#"+id).append(
                                "<td>"+ current_gpu +"</td>" +
                                "<td>"+ current_cpu +"</td>" +
                                "<td>"+ current_emu +"</td>" +
                                "<td>"+ current_loc +"</td>" +
                                "<td>"+ current_bench +"</td>" +
                                "<td>"+ current_user +"</td>"
                            );
                        }
                    }
                }
            } 
            
            //for the filters
            if(gpu_list.includes(current_gpu) === false) {
                $("#gpu-filter").append(
                    "<option>"+ current_gpu +"</option>"
                );

                gpu_list.push(current_gpu);
            }

            if(cpu_list.includes(current_cpu) === false) {
                $("#cpu-filter").append(
                    "<option>"+ current_cpu +"</option>"
                );

                cpu_list.push(current_cpu);
            }
            
            if(emu_list.includes(current_emu) === false) {
                $("#emulator-filter").append(
                    "<option>"+ current_emu +"</option>"
                );

                emu_list.push(current_emu)
            }

            if(loc_list.includes(current_loc) === false) {
                $("#location-filter").append(
                    "<option>"+ current_loc +"</option>"
                );

                loc_list.push(current_loc);
            }

        }
    }
    
)};

    //initial call
    HtmlGenerator();