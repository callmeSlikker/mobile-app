<!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guestbook</title>
    <link rel="stylesheet" type="text/css" href="./style.css">
<style>

.pagination {
    margin-top: 20px;
}

.pagination a {
    color: #00ff;
    padding: 8px 16px;
    text-decoration: none;
    border: 1px solid #ddd;
    margin-right: 5px;
}

.pagination a.active {
    background-color: #4CAF50;
    color: white;
}

.page-number {
    margin-right: 5px;
}
</style>
</head>
<body>
    <!-- Menu section -->
<div class="menu" id="menu">
    <a href="CV.html">Home</a>
    <a href="#">Project</a>
    <a href="viewguestbook.php">Guestbook</a>
</div>

<div class="container">
    <h3>Comment from guests</h3> 
    <?php
    // Connect to server and select database.
    include("config.php");

    $page = isset($_GET['page']) ? $_GET['page'] : 1; // หน้าปัจจุบัน
    $records_per_page = 3; // จำนวนข้อความต่อหน้า
    $offset = ($page - 1) * $records_per_page; // ค่า offset

    $sql = "SELECT * FROM guestbook ORDER BY id DESC LIMIT $offset, $records_per_page";
    $objQuery = mysqli_query($objCon, $sql);
    ?>

<div class="comment-section">
    <?php while ($rows = mysqli_fetch_array($objQuery)) { ?>
        <div class="comment">
            <p><?php echo $rows['comment']; ?></p>
            <p class="author"><?php echo $rows['name']; ?>
                <span class="date"><?php echo date('d/m/y', strtotime($rows['datetime'])); ?></span>
            </p>
        </div>
    <?php } ?>
</div>

<?php
// หาจำนวนข้อมูลทั้งหมด
$total_pages_sql = "SELECT COUNT(*) FROM guestbook";
$result = mysqli_query($objCon, $total_pages_sql);
$total_rows = mysqli_fetch_array($result)[0];
$total_pages = ceil($total_rows / $records_per_page);

// สร้างลิงก์สำหรับแต่ละหน้า
echo "<div class='pagination'>";
for ($i = 1; $i <= $total_pages; $i++) {
    echo "<a href='viewguestbook.php?page=".$i."' ";
    if($i==$page) echo "class='active'";
    echo "><span class='page-number'>".$i."</span></a>";
}
echo "</div>";
?>

    <h3>Add comment</h3>
    <form id="form1" name="form1" method="post" action="addcomment.php">
        <table class="comment-form">
            <tr>
                <td width= 80px><label for="name">Name</label></td>
                <td><input name="name" type="text" id="name" /></td>
            </tr>
            <tr>
                <td><label for="email">Email</label></td>
                <td><input name="email" type="text" id="email" /></td>
            </tr>
            <tr>
                <td valign="top"><label for="comment">Comment</label></td>
                <td><textarea name="comment" id="comment" rows="3"></textarea></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <input type="submit" name="Submit" value="Submit" />
                    <input type="reset" name="Submit2" value="Reset" />
                </td>
            </tr>
        </table>
    </form>
</div>

<?php mysqli_close($objCon); ?>

<!-- Code injected by live-server -->
<script>
	// <![CDATA[  <-- For SVG support
	if ('WebSocket' in window) {
		(function () {
			function refreshCSS() {
				var sheets = [].slice.call(document.getElementsByTagName("link"));
				var head = document.getElementsByTagName("head")[0];
				for (var i = 0; i < sheets.length; ++i) {
					var elem = sheets[i];
					var parent = elem.parentElement || head;
					parent.removeChild(elem);
					var rel = elem.rel;
					if (elem.href && typeof rel != "string" || rel.length == 0 || rel.toLowerCase() == "stylesheet") {
						var url = elem.href.replace(/(&|\?)_cacheOverride=\d+/, '');
						elem.href = url + (url.indexOf('?') >= 0 ? '&' : '?') + '_cacheOverride=' + (new Date().valueOf());
					}
					parent.appendChild(elem);
				}
			}
			var protocol = window.location.protocol === 'http:' ? 'ws://' : 'wss://';
			var address = protocol + window.location.host + window.location.pathname + '/ws';
			var socket = new WebSocket(address);
			socket.onmessage = function (msg) {
				if (msg.data == 'reload') window.location.reload();
				else if (msg.data == 'refreshcss') refreshCSS();
			};
			if (sessionStorage && !sessionStorage.getItem('IsThisFirstTime_Log_From_LiveServer')) {
				console.log('Live reload enabled.');
				sessionStorage.setItem('IsThisFirstTime_Log_From_LiveServer', true);
			}
		})();
	}
	else {
		console.error('Upgrade your browser. This Browser is NOT supported WebSocket for Live-Reloading.');
	}
	// ]]>
</script>
</body>
</html>
