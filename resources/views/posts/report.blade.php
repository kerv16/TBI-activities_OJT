<x-app-layout title="Report">
    <div class="w-full min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div>
            <span class="text-blue-900 text-2xl font-bold">Generate Report and Activities for TBI</span>
        </div>
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div class="mb-4">
                <x-label class="font-semibold" for="date" value="{{ __('Date') }}" />
            </div>
            <div class="mb-4">
                <select class="rounded-2xl text-center" id="monthDropdownReport">
                    <option value="">Select a month</option>
                    @for ($month = 1; $month <= 12; $month++) <option value="{{ $month }}">{{ date('F', mktime(0, 0, 0,
                        $month, 1)) }}</option>
                        @endfor
                </select>
                <select class="rounded-2xl text-center" id="yearDropdownReport">
                    <option value="">Select a year</option>
                    @for ($year = date('Y'); $year >= 2023; $year--)
                    <option value="{{ $year }}">{{ $year }}</option>
                    @endfor
                </select>
            </div>
            <div class="flex items-center justify-end mt-4">
                <x-button class="ms-4" onclick="generateReport()">
                    {{ __('Generate Report') }}
                </x-button>
            </div>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div class="mb-4">
                <x-label class="font-semibold" for="date" value="{{ __('Date') }}" />
            </div>
            <div class="mb-4">
                <select class="rounded-2xl text-center" id="monthDropdownActivities">
                    <option value="">Select a month</option>
                    @for ($month = 1; $month <= 12; $month++) <option value="{{ $month }}">{{ date('F', mktime(0, 0, 0,
                        $month, 1)) }}</option>
                        @endfor
                </select>
                <select class="rounded-2xl text-center" id="yearDropdownActivities">
                    <option value="">Select a year</option>
                    @for ($year = date('Y'); $year >= 2023; $year--)
                    <option value="{{ $year }}">{{ $year }}</option>
                    @endfor
                </select>
            </div>
            <div class="flex items-center justify-end mt-4">
                <x-button class="ms-4" onclick="generateActivities()">
                    {{ __('Generate Activities') }}
                </x-button>
            </div>
        </div>
    </div>

    <script>
        function generateReport() {
            const month = document.getElementById('monthDropdownReport').value;
            const year = document.getElementById('yearDropdownReport').value;
            generate('report', year, month);
        }

        function generateActivities() {
            const month = document.getElementById('monthDropdownActivities').value;
            const year = document.getElementById('yearDropdownActivities').value;
            generate('activities', year, month);
        }

        function generate(type, year, month) {
            if (year) {
                let url = `/generate-${type}/${year}`;
                if (month) {
                    url += `/${month}`;
                }
                fetch(url)
                    .then(response => {
                        if (response.status === 204) {
                            alert(`There are no ${type} for the selected month or year.`);
                            return Promise.reject('No events found');
                        }
                        if (!response.ok) {
                            throw new Error(`Failed to generate ${type}`);
                        }
                        // Handle successful generation
                        window.open(url, '_blank');
                    })
                    .catch(error => {
                        console.error(`There has been a problem with your fetch operation:`, error);
                    });
            } else {
                alert('Please select a year.');
            }
        }
    </script>
</x-app-layout>