@props(['all','value'])
<a href="javascript:void(0);" id="icon" class="flex items-center gap-1 hover:text-blue-500" onclick="toggleBroadcastInfo('Div')">
<div class="relative group flex items-center">
    <svg class="svg w-10 h-10 ml-3 hover:scale-110 text-green-600 transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M3.267 1.457c.3.286.312.76.026 1.06A6.475 6.475 0 001.5 7a6.472 6.472 0 001.793 4.483.75.75 0 01-1.086 1.034 8.89 8.89 0 01-.276-.304l.569-.49-.569.49A7.971 7.971 0 010 7c0-2.139.84-4.083 2.207-5.517a.75.75 0 011.06-.026zm9.466 0a.75.75 0 011.06.026A7.975 7.975 0 0116 7c0 2.139-.84 4.083-2.207 5.517a.75.75 0 11-1.086-1.034A6.475 6.475 0 0014.5 7a6.475 6.475 0 00-1.793-4.483.75.75 0 01.026-1.06zM8.75 8.582a1.75 1.75 0 10-1.5 0v5.668a.75.75 0 001.5 0V8.582zM5.331 4.736a.75.75 0 10-1.143-.972A4.983 4.983 0 003 7c0 1.227.443 2.352 1.177 3.222a.75.75 0 001.146-.967A3.483 3.483 0 014.5 7c0-.864.312-1.654.831-2.264zm6.492-.958a.75.75 0 00-1.146.967c.514.61.823 1.395.823 2.255 0 .86-.31 1.646-.823 2.255a.75.75 0 101.146.967A4.983 4.983 0 0013 7a4.983 4.983 0 00-1.177-3.222z"></path>
    </svg>
</div>
</a>
<form action="{{ route(auth()->user()->roleName . 'sms.broadcast') }}" method="get">
    <div id="Div" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 overflow-y-auto">
        <div class="bg-white p-6 rounded shadow-lg max-w-5xl">
            <p class="float-right"><svg class="w-8 h-8 text-red-500 hover:scale-110 cursor-pointer" id="close" onclick="toggleBroadcastInfo('Div')" xmlns="http://www.w3.org/2000/svg" role="img" viewBox="0 0 24 24" aria-labelledby="cancelIconTitle" fill="none" stroke="currentColor">
                    <title id="cancelIconTitle">Cancel</title>
                    <path d="M15.5355339 15.5355339L8.46446609 8.46446609M15.5355339 8.46446609L8.46446609 15.5355339"></path>
                    <path d="M4.92893219,19.0710678 C1.02368927,15.1658249 1.02368927,8.83417511 4.92893219,4.92893219 C8.83417511,1.02368927 15.1658249,1.02368927 19.0710678,4.92893219 C22.9763107,8.83417511 22.9763107,15.1658249 19.0710678,19.0710678 C15.1658249,22.9763107 8.83417511,22.9763107 4.92893219,19.0710678 Z"></path>
                </svg></p>
            <!-- dropdown for user type -->
            <!-- <div class="sm:col-span-3">
                <select name="all" id="all"
                    class="all block mt-1 w-56 border-gray-300 focus:border-orange-600 focus:ring-orange-600 rounded-md shadow-sm" required>
                    <option value="" disabled selected>Select Type</option>
                    @foreach ($all as $key => $collection)
                    <option value="{{ $key }}">
                        {{ ucfirst($key) }} 
                    </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('all')" class="mt-2" />
            </div> -->
            <h2 class="text-lg font-bold text-center flex items-center justify-center mb-4">
                Broadcasting
                <svg class="h-8 w-8 text-orange-500 ml-2 mr-2 hover:scale-110" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" />
                    <path d="M21 14l-3 -3h-7a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1h9a1 1 0 0 1 1 1v10" />
                    <path d="M14 15v2a1 1 0 0 1 -1 1h-7l-3 3v-10a1 1 0 0 1 1 -1h2" />
                </svg>
                <div class="sm:col-span-3">
                    <select name="templates" id="templates"
                        class="templates block mt-1 w-full border-gray-300 focus:border-orange-600 focus:ring-orange-600 rounded-md shadow-sm" required>
                        <option value="" disabled selected>Select Template</option>
                        @foreach ($all['templates'] as $template)
                        <option value="{{ $template->id }}">
                            {{ $template->title }}
                        </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('templates')" class="mt-2" />
                </div>
            </h2>
            <div class="sm:col-span-3">
                <div class="flex flex-row justify-between">
                    <input type="text" id="searchBox" class="block mt-1 border-gray-300 rounded-md shadow-sm w-1/3 mb-2" placeholder="Search members..." onkeyup="filterMembers()" />
                    <div class="inline-flex items-center mt-2 mb-2">
                        <input type="checkbox" id="selectAll" onchange="toggleSelectAll(this)" />
                        <span class="ml-2">Select All</span>
                    </div>
                </div>
                <div id="member-checkboxes" class="grid grid-cols-2 sm:grid-cols-5 max-h-60 overflow-y-auto border border-gray-300 rounded p-2">
                    @foreach ($all['leads'] as $lead)
                    <label class="inline-flex items-center mt-2 member-label">
                        <input type="checkbox" value="{{ $lead->id }}" class="member-checkbox mr-2 ml-3" onchange="updateSelectedMembers()" />
                        <span>{{ $lead->first_name.' '.$lead->last_name}}</span>
                    </label>
                    @endforeach
                </div>
                <x-input-error :messages="$errors->get('members')" class="mt-2" />
            </div>
            <span id="cancelButton" class="m-1 text-black rounded cursor-pointer float-right hover:text-green-700" onclick="clearSelections()">Clear</span>
            <div class="sm:col-span-3 mb-4">
                <input type="text" id="selectedMembers" class="block mt-1 border-gray-300 rounded-md shadow-sm w-full" name="leads" readonly placeholder="Selected members will appear here..."></input>
            </div>
            <div class="flex flex-row justify-center">
                <button type="submit" id="sendSmsLink" class="cursor-pointer"><svg class="w-12 h-12 mt-1 rounded-md bg-green-100 px-2 py-1 text-xs font-medium text-green-800 ring-1 ring-inset ring-green-600/70 hover:scale-105 " xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M3.05 3.05a7 7 0 0 0 0 9.9.5.5 0 0 1-.707.707 8 8 0 0 1 0-11.314.5.5 0 0 1 .707.707m2.122 2.122a4 4 0 0 0 0 5.656.5.5 0 1 1-.708.708 5 5 0 0 1 0-7.072.5.5 0 0 1 .708.708m5.656-.708a.5.5 0 0 1 .708 0 5 5 0 0 1 0 7.072.5.5 0 1 1-.708-.708 4 4 0 0 0 0-5.656.5.5 0 0 1 0-.708m2.122-2.12a.5.5 0 0 1 .707 0 8 8 0 0 1 0 11.313.5.5 0 0 1-.707-.707 7 7 0 0 0 0-9.9.5.5 0 0 1 0-.707zM6 8a2 2 0 1 1 2.5 1.937V15.5a.5.5 0 0 1-1 0V9.937A2 2 0 0 1 6 8"></path>
                    </svg></button>
            </div>
</form>


</div>
</div>

<script>
    function toggleBroadcastInfo(id) {
        const Div = document.getElementById('Div');
        Div.classList.toggle('hidden');
        //clear all checked  checkboxes
        clearSelections();
        //clear the selected dropdown value
        $dropdown = document.getElementById('templates');
        $dropdown.selectedIndex = 0;

    }
    document.getElementById('Div').addEventListener('click', function(event) {
        if (event.target === this) {
            toggleBroadcastInfo();

        }
    });

    function updateSelectedMembers() {
        const checkboxes = document.querySelectorAll('.member-checkbox');
        const selectedNames = [];
        const selectedIds = [];

        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                selectedNames.push(checkbox.nextElementSibling.textContent); // Get the name next to the checkbox
                selectedIds.push(checkbox.value); // Get the ID of the checked checkbox
            }
        });

        // Update the input field with selected names
        document.getElementById('selectedMembers').value = selectedIds.join(', ');

        // Log selected IDs for further processing
        console.log(selectedIds); // You can handle the IDs as needed
    }

    function toggleSelectAll(selectAllCheckbox) {
        const checkboxes = document.querySelectorAll('.member-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = selectAllCheckbox.checked;
        });
        updateSelectedMembers(); // Update the selected members when toggling select all
    }

    function filterMembers() {
        const searchBox = document.getElementById('searchBox').value.toLowerCase();
        const labels = document.querySelectorAll('.member-label');

        labels.forEach(label => {
            const memberName = label.textContent.toLowerCase();
            label.style.display = memberName.includes(searchBox) ? 'flex' : 'none';
        });
    }

    function clearSelections() {
        // Clear selected members input
        document.getElementById('selectedMembers').value = '';

        // Uncheck all checkboxes
        const checkboxes = document.querySelectorAll('.member-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = false;
        });

        // Uncheck the "Select All" checkbox
        document.getElementById('selectAll').checked = false;
    }

    // Example usage: Call this function when needed to get selected IDs
    document.getElementById('close').addEventListener('click', function() {
        const selectedIds = Array.from(document.querySelectorAll('.member-checkbox:checked')).map(checkbox => checkbox.value);
        console.log(selectedIds); // Handle the selected IDs (e.g., send them in a request or log them)
    });

    //for selecting user type
    // document.getElementById('all').addEventListener('change', function() {
    //     var value=this.value; 
    //     console.log(value);
    // });
</script>