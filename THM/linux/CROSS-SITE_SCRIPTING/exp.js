<script>
 for (let i = 0; i < 256; i++) {
  let ip = '192.168.1.' + i
  let code = '<img src="http://' + ip + '/favicon.ico" onload="this.onerror=null; this.src=/log/' + ip + '">'
  document.body.innerHTML += code
 }
</script> 