<link href="<?php echo $path; ?>css/dcaccordion.css" rel="stylesheet" type="text/css" />
<script type='text/javascript' src='<?php echo $path; ?>js/jquery.cookie.js'></script>
<script type='text/javascript' src='<?php echo $path; ?>js/jquery.hoverIntent.minified.js'></script>
<script type='text/javascript' src='<?php echo $path; ?>js/jquery.dcjqaccordion.2.7.min.js'></script>
<script type="text/javascript">
    $(document).ready(function($){
        $('#accordion-6').dcAccordion({
            eventType: 'hover',
            autoClose: true,
            saveState: true,
            disableLink: false,
            showCount: false,
            menuClose: true,
            speed: 'slow'
        });
    });
</script>
<link href="<?php echo $path; ?>css/skins/blue.css" rel="stylesheet" type="text/css" />
<table width="978" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top">
    <table width="978" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="220" height="5"></td>
        <td width="10" height="5"></td>
        <td width="748"></td>
      </tr>
      <tr>
        <td align="left" valign="top" style="background-color: rgba(255, 255, 255, 0.4);">
            <div class="blue demo-container">
                <ul class="accordion" id="accordion-6">
                    <?php
                    $p_id = $_GET['p_id'];

                    $p_id_query = query("select `parent_menu_id` from `menus` where `menu_id`='".$p_id."' and `parent_menu_id` != '0';");
                    if(mysql_num_rows($p_id_query) > 0) {
                        $p_id_result = mysql_fetch_array($p_id_query);
                        $p_id = $p_id_result['parent_menu_id'];
                    }

                    $sub_menu_query = query("select `menu_id`,`menu_name` from `menus` where `parent_menu_id`='".$p_id."' and `is_active`='1' order by `order` asc;");
                    //$sub_menu_query = query("select `album_id`,`album_name` from `photo_album` where `menu_id`='".$_GET['p_id']."' order by `album_id` asc;");
                    while($result_submenu = mysql_fetch_array($sub_menu_query))
                    {
                        echo '<li>';
                        echo '<a href="index.php?p_id='.$result_submenu['menu_id'].'" class="sidemenu">'.$result_submenu['menu_name'].'</a>';
                        //echo '<a href="javascript:void(0)">'.$result_submenu['menu_name'].'</a>';
                        $sub_album_menu_query = query("select `album_id`,`album_name` from `photo_album` where `menu_id`='".$result_submenu['menu_id']."' order by `album_id` asc;");
                        while($result_album_submenu = mysql_fetch_array($sub_album_menu_query))
                        {
                            echo '<ul>';
                            echo '<li><a href="index.php?p_id='.$_GET['p_id'].'&sub_id='.$result_submenu['menu_id'].'&album_id='.$result_album_submenu['album_id'].'">'.$result_album_submenu["album_name"].'</a></li>';
                            echo '</ul>';
                        }
                        echo '</li>';
                    }
                    ?>
                </ul>
            </div>
        <!--<table width="184" border="0" cellspacing="0" cellpadding="0">
        	<?php
/*				$sub_menu_query = query("select `album_id`,`album_name` from `photo_album` where `menu_id`='".$_GET['p_id']."' order by `album_id` asc;");
				while($result_submenu = mysql_fetch_array($sub_menu_query))
				{
					echo '<tr>
							<td><a href="index.php?p_id='.$_GET['p_id'].'&album_id='.$result_submenu['album_id'].'" class="sidemenu">'.$result_submenu['album_name'].'</a></td>
						  </tr>
						  <tr>
							<td height="5"></td>
						  </tr>';
				}
			*/?>
        </table>-->
        </td>
        <td width="10" style="background-color: rgba(255, 255, 255, 0);"></td>
        <td align="left" valign="top" style="background-color: rgba(255, 255, 255, 0.4);">
        <table width="740" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td></td>
            <td align="center" valign="top" height="5">
            </td>
          </tr>
          <tr>
            <td width="5"></td>
            <td width="735" align="center" valign="top">
            <table width="725" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td align="left" valign="top">
                	<?php
					if(empty($_GET['album_id']))
						echo '<div style="float:left;display:block;width:690px;">'.$con.'</div>';
					else
					{
						$album_query = query("SELECT `description` FROM `photo_album` where `album_id`='".$_GET['album_id']."';");
						$album_result = mysql_fetch_array($album_query);
						$description = $album_result['description'];
						//echo '<div style="float:left;display:block;width:690px;">'.$description.'</div>';
					}
					?>
                </td>
              </tr>
              <tr>
                <td align="center" valign="top" height="300px">
                    <div id="gallerys" class="row-fluid" align="center" style="height:auto;">
                        <ul class="thumbnails">
                    	<?php
							if(empty($_GET['album_id']))
							{
								$gallery_images_query=query("select `photo_id`, `photos`.`album_id` as album_id, `title`, `pic_dir` from `photos`, `photo_album` where photo_album.menu_id='".$_GET['p_id']."' and photo_album.album_id=photos.album_id order by photo_id desc limit 0;");
							}
							else
							{
								$gallery_images_query=query("select `photo_id`, `title`, `pic_dir` from `photos` where photos.album_id='".$_GET['album_id']."'");
							$album_id=$_GET['album_id'];
							}
							
							$count = mysql_num_rows($gallery_images_query);
							if($count>0)
							{
								while($gallery_images_result=mysql_fetch_array($gallery_images_query))
								{
									if(empty($_GET['album_id']))
										$album_id=$gallery_images_result['album_id'];
									echo '<li class="span3">
									        <div class="thumbnail">
											    <a href="index.php?p_id='.$_GET['p_id'].'&album_id='.$album_id.'&photo_id='.$gallery_images_result['photo_id'].'"><img src="../upload_small/'.$gallery_images_result['pic_dir'].'" style="width: 260px; height: auto;" alt="'.$gallery_images_result['title'].'" /></a>
											    <h5>'.$gallery_images_result['title'].'</h5>
											</div>
							              </li>';
								}
							}
							else
							{
								if(!empty($_GET['album_id']))
									echo '<br /><br /><div style="height:200px;">There are nothing to see in this gallery</div>';
							}
						?>
                        </ul>
                    </div>
                </td>
              </tr>
              <tr>
                <td align="center" height="10">                </td>
              </tr>
            </table>                
            </td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="5"></td>
  </tr>
</table>