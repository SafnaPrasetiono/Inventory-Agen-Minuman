// membuat menu dropdown pada ul yang berada di dalam ul di adminform
//bila a di klik maka
// $(".menu").click(function(e){
// 	//akan terjadi slide pada ul yang berada di dalamnya
// 	$(".menu ul ul").slideUp(),
// 	//jika dalam a dijalan kan maka akan visible(terlihat / dropdown)
// 	$(this).next().is(":visible") || $(this).next().slideDown(),
// 	//menghentikan aksi dari fungsi
// 	e.stopPropagation()
// })
$(document).ready(function(){
    $(".open-menu").click(function(){
        $(document.getElementById("open-menu-up")).slideToggle();
        // $("#open-menu-up")..animate({width: 'toggle'});
    })
})
$(window).bind("load resize", function(){
	//apa bila besar dari tampilan kurang dari 789 makan akan dibuat class collapse dari bootstrap tersebut
	//apa bula besar dari tampilan lebuh dari 789 maka class bootstrap akan di hapus
	if ($(this).width() < 789){
		$("#open-menu-up").addClass("collapse");
	}
	else{
		$("#open-menu-up").removeClass("collapse");
		//menghapus atribut syle agar warna bacground dari slide bar kembali
		//seperti semula
		$("#open-menu-up").removeAttr("style");
	}

})
