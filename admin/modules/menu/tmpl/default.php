<?php
defined('_MEXEC') or die ('Restricted Access');
global $v_view;
global $task;
$class = '';

?>

<ul class="menu">
		<?php 
	$has_active=false;
	foreach ($rows as $row):
		$class = ''; 
		$link = 'index.php';
		if ($row['link_type'] != ''){
			$link .= '?option=' . $row['link_type'];
		}
		if ($row['link'] != ''){
			$link .= '&view=' . $row['link'];
		} else{
			//$class = 'class="current active"';
		}
		
		if ($row['link'] == $v_view.'&task='.$task ){
			$class = 'class="current active"';
			$has_active=true;
		} 
		if ($row['link'] == $v_view){
			if($has_active==false){
				$class = 'class="current active"';
			}
		}
		
?>
		
			<li <?php echo $class; ?> ><a href="<?php echo $link; ?>"><?php echo $row['title']; ?></a>
				<?php 
					if ($row['title']=='Packages' && isset($packages)){
						echo '<ul class="children">';
						foreach ($packages as $package):
						$package_link='index.php?option=onlinejobs&view=packages&task=show&ItemID=' . $package['id'];
							echo '<li>';
							echo '<a href="' . $package_link . '" title="' . $package['title'] . '"> ' . $package['title'] . '</a>' ;
							echo '</li>';
						endforeach;
						echo '</ul>';
					}
				?>
			</li>
		<?php endforeach; ?>
		</ul>
		

		