<!DOCTYPE html>
<html>
<head>
    <title>AI Study Guide</title>
</head>
<body>
    <h1>AI Study Guide Generator</h1>
    <form method="POST" action="{{ route('study.generate') }}">
        @csrf

        <label for="notes">Paste your notes:</label><br>
        <textarea name="notes" rows="10" cols="70" required>{{ old('notes') }}</textarea><br><br>

        <label>Choose output type:</label><br>
        <select name="type">
            <option value="summary">Summary</option>
            <option value="quiz">Quiz Questions</option>
        </select><br><br>

        <button type="submit">Generate</button>
    </form>

    @if(session('output'))
        <h2>AI Output:</h2>
        <pre>{{ session('output') }}</pre>
    @endif
</body>
</html>
