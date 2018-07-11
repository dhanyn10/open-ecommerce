{{session()->flush()}}
berhasil keluar
<script>
setTimeout(function(){
    window.location = "{{route('masuk')}}";
},1000);
</script>