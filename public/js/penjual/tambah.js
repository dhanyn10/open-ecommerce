function bacagambar(input)
{
    if(input.files && input.files[0])
    {
        var reader = new FileReader();
        reader.onload = function(e)
        {
            $("#foto-barang").attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
function croppergambar()
{
    $("#foto-barang").cropper({
        aspectRatio: 4/4,
        zoomable:true,
        autoCropArea: 1.0,
        cropBoxResizable:true,
        crop: function(e) {
        }
    });
    data_url =  $("#foto-barang").cropper('getCroppedCanvas',{
        height:150,
        width:150
    }).toDataURL();
    $("#input-barang").val(data_url);
}
$("#cekbarang").change(function(){
    if($(".cropper-container").length)
        {
            $("#form-barang").html('<img name="foto-barang" id="foto-barang"/>');
        }
    bacagambar(this);
    setTimeout(function(){
        croppergambar();
    },100);
    $("#crop").css("display","block");
});
$("#crop").click(function(){
    barang = $("#foto-barang").cropper('getCroppedCanvas',{
        height:150,
        width:150
    }).toDataURL();
    $("#form-barang").html('<img name="foto-barang" id="foto-barang" src="'+barang+'"/>');
    $("input[name='input-barang']").eq(0).val(barang);
    //hilangkan tombol potong
    $("#crop").css("display", "none");
});