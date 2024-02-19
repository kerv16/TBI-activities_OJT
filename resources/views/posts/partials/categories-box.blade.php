<div>
    <h3 class="mb-3 text-lg font-semibold text-gray-900">Project Categories</h3>
    <div class="flex flex-wrap justify-start gap-2 topics">
        @foreach ($categories as $category)
            <x-posts.category-badge :category="$category" />
        @endforeach
    </div>
    <br>
    <h3 class="mb-3 text-lg font-semibold text-gray-900 mt-4">Year</h3>
    <div class="flex flex-wrap justify-start gap-2 topics">
        @foreach (range(date('Y'), 2023) as $year)
            <x-posts.year-badge :year="$year" />
        @endforeach
    </div>

</div>

