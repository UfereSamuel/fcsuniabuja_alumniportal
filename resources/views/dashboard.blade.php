<script>
window.location.href = "{{ route('dashboard') }}";
</script>

<noscript>
<meta http-equiv="refresh" content="0;url={{ route('dashboard') }}">
</noscript>

<div class="text-center py-12">
    <p>Redirecting to your dashboard...</p>
    <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline">Click here if not redirected automatically</a>
</div>
