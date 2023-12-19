<!-- Ensure you have the CSRF token in your HTML -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<form id="myForm">
    <label for="param1">Vip rank:</label>
    <input type="text" id="param1" name="param1" placeholder="v1,v2,v3,v4(with no spacing)"><br><br>

    <label for="param2">Tier Level:</label>
    <input type="text" id="param2" name="param2" placeholder="1,2,3,4,5(with no spacing)"><br><br>

    <button type="button" id="submitBtn">Submit</button>
</form>

<div id="result"></div>

<script>
    document.getElementById('submitBtn').addEventListener('click', function() {
        var param1Value = document.getElementById('param1').value;
        var param2Value = document.getElementById('param2').value;

        // Get the CSRF token value from the meta tag
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Ajax request with CSRF token included in headers
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/processVipTier', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('X-CSRF-Token', csrfToken); // Include CSRF token in headers
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    document.getElementById('result').innerHTML = xhr.responseText;
                } else {
                    console.error('Request failed');
                }
            }
        };

        var data = JSON.stringify({ param1: param1Value, param2: param2Value });
        xhr.send(data);
    });
</script>
