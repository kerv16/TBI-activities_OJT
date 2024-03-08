<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TBI-REPORT</title>
</head>

<style>
  .description {
    text-align: justify;
  }

  .post {
    page-break-after: always;
  }
</style>

<body>
  <div style="text-align:center">
    <h1>{{ $eventLabel }} for {{ $dateLabel }}</h1>
  </div>
  <br>
  <hr>
  <br>

  @foreach ($posts as $post)
  <div class="post">
    <p> <strong>Event Name: </strong> {{ $post->title }}
    <p><strong>Event Type:</strong> {{ $post->event_type }}</p>
    <p><strong>Date:</strong> {{ $post->published_at->format('F d, Y') }}</p>
    <p><strong>No. of Participants:</strong> {{ $post->number_of_participants }}</p>

    @if ($post->image)
    @php
    $imagePath = $post->getThumbnailUrl();
    if (!str_contains($imagePath, 'http')) {
    $imagePath = public_path($imagePath);
    }
    $ext = pathinfo($imagePath, PATHINFO_EXTENSION);
    $mime = 'image/' . ($ext == 'svg' ? 'svg+xml' : $ext);
    $imageName = basename($imagePath);
    @endphp
    <div style="text-align: center;">
      <img src="data:{{ $mime }};base64,{{ base64_encode(file_get_contents($imagePath)) }}" alt="Event Image"
        width="400" height="300">
    </div>
    @endif

    <div class="description">
      <p>{!! str_replace($imageName, '', strip_tags($post->body, '<p><a><ul><ol><li><strong><em><u><br><span><h1><h2><h3><h4><h5><h6>')) !!}</p>
    </div>
    <br>
    <br>
    <br>
    <br>
  </div>
  @endforeach
</body>

</html>