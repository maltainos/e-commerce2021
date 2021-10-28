onmouseout
function getCategoryId(){
    var category = document.getElementById('category_field').value;
    alert(category);
}

function changeText(){
    var text = document.getElementById('file').value;
    document.getElementById('label-image').innerHTML = text;
    changeImage();
}

function changeImage(){
    //alert("Change Image");
    var image = document.getElementById('file').value;
    document.getElementById('image').src = image;
}