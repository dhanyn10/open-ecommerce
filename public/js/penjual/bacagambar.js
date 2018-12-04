function bacagambar(input)
{
    if(input.files && input.files[0])
    {
        var reader = new FileReader();
        reader.onload = function(e)
        {
            $("#preview-gambar").attr('src', e.target.result);
            $("#data-gambar").val(e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#gambar").change(function(){
    bacagambar(this);
});