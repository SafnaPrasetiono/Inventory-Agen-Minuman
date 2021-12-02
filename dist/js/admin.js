// membuat menu dropdown pada ul yang berada di dalam ul di adminform
//bila a di klik maka
$(".menu li > a").click(function(e){
	//akan terjadi slide pada ul yang berada di dalamnya
	$(".menu ul ul").slideUp(),
	//jika dalam a dijalan kan maka akan visible(terlihat / dropdown)
	$(this).next().is(":visible") || $(this).next().slideDown(),
	//menghentikan aksi dari fungsi
	e.stopPropagation()
})

$(window).bind("load resize", function(){
	//apa bila besar dari tampilan kurang dari 789 makan akan dibuat class collapse dari bootstrap tersebut
	//apa bula besar dari tampilan lebuh dari 789 maka class bootstrap akan di hapus
	if ($(this).width() < 789){
		$(".sidebar-collapse").addClass("collapse");
	}
	else{
		$(".sidebar-collapse").removeClass("collapse");
		//menghapus atribut syle agar warna bacground dari slide bar kembali
		//seperti semula
		$(".sidebar-collapse").removeAttr("style");
	}

})