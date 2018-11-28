
 function dd(link){

	var wd = document.body.clientWidth;
    		if (wd < '640') {
      		layer.open({
	            type: 2,
	            title: 'Welcome',
	            maxmin: true,
	            shadeClose: true, //点击遮罩关闭层
	            area : ['100%' , '100%'],
	            content: link
	          	});
        	}else{
        		layer.open({
		        type: 2,
		        title: 'Welcome',
		        maxmin: true,
		        shade: 0.6,
		        shadeClose: true, //点击遮罩关闭层
		        area : ['60%' , '100%'],
		        content: link
        		});
      		}
}



