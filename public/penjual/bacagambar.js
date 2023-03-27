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
function GetFileSize(input)
{
    fsize_kb = 0;
    if(input.files.length > 0)
    {
        for(var f = 0; f < input.files.length; f++)
        {
            fsize       = input.files.item(f).size;
            fsize_kb    = Math.round((fsize / 1024));
        }
    }
    return fsize_kb;
}

$("#gambar").change(function()
{
    if(GetFileSize(this) <= 500)
    {
        bacagambar(this);
    }
    else
    {
        alert('Ukuran gambar terlalu besar');
        $(this).val(null);
    }
});