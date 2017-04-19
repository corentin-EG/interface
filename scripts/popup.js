var assetList = document.getElementById("objectList").getElementsByClassName("asset");

var bg = document.getElementById("popup-bg").addEventListener("click", popupDetail);

for (var i = 0; i < assetList.length; i++)
	assetList[i].addEventListener("click", popupDetail);

function popupDetail(e) {
	
	var bg = document.getElementById("popup-bg");
	var popup = document.getElementById("popup-item-detail");
	
	switch (getComputedStyle(bg).getPropertyValue('display')) {
		case "none":
			popup.style.display = "block";
			bg.style.display = "block";
			break;

		case "block":
			popup.style.display = "none";
			bg.style.display = "none";
			return;
			break;
	}

	var id = encodeURIComponent(e.target.id);

	var xhr = new XMLHttpRequest();
	xhr.open('POST', 'model/serviceAjax.php');
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	xhr.addEventListener('readystatechange', function(){
		if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
		{
			var asset = JSON.parse(xhr.responseText);
			var title = popup.children[0];
			title.innerHTML = asset.name;

			(function() {
				var originalDiv = popup.children[1];
				var img = originalDiv.children[1];
				// img.addEventListener("load", function() {
				// 	var name = originalDiv.children[2];
				// 	var dimension = originalDiv.children[3];
				// 	var size = originalDiv.children[4];

				// 	//name.textContent = url.substring(url.lastIndexOf("/") + 1, url.length);
				// 	dimension.textContent = img.naturalWidth+' x '+img.naturalHeight;
				// 	size.textContent =  Math.round(img.size/1024) +'KB';

				// });
				img.src = asset.sourceUrl;
			})();


			(function() {
				var uploadedDiv = popup.children[2];
				var fileInput = uploadedDiv.children[1];
				var img = uploadedDiv.children[2];
				var filename = uploadedDiv.children[3];
				if (asset.targetUrl === null) {
					console.log(uploadedDiv);
					img.style.display = "none";
					filename.style.display = "none";
					fileInput.style.display = "block";
				} else {
					var url = asset.targetUrl;
					img.src = url;
					//filenameElt.textContent = url.substring(url.lastIndexOf("/") + 1, url.length);
					fileInput.style.display = "none";
					img.style.display = "block";
					//filenameElt.style.display = "block";
				}
			})();

			// var note = popup.children[5];
			// note.innerHTML = asset.note;
			// var author = popup.children[6];

			// var currentDate = new Date();
			// var dd = currentDate.getDate();
			// var mm = currentDate.getMonth()+1;
			// var yyyy = currentDate.getFullYear();
			// dd = dd < 10 ? "0"+dd : dd;
			// mm = mm < 10 ? "0"+mm : mm;
			// currentDate = dd+'/'+mm+'/'+yyyy;

			// author.innerHTML = "Uploaded by "+ asset.author +", "+ currentDate +".";
		}
	});

	xhr.send('service=asset&id='+ id);
}


function popupImageReader(image)
{
	var myImg = new Image();
	// myImg.addEventListener("load", function() {
	// 	img
	// })
}