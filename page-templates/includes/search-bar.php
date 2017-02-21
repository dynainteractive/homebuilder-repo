        <div class="search-bar">
			<form action="<?php echo get_permalink( $post->ID ); ?>" method="POST" class="remove-bottom">
                <select name="comm_name" style="width:300px;">
                    <option value="0">Select Community</option>
                    <?php 
                    $args = array(
                        'post_type'			=> 'communities',
                        'posts_per_page'	=> -1,
                        'order_by'			=> title,
                        'order'				=> ASC
                    );
                    query_posts( $args );
                    while (have_posts()) : the_post();
                   	if(get_field('state') == $m):
                        $comm = get_field('community_name');
                        $id = get_the_ID();
                    ?>
                        <option value="<?php echo $id; ?>" <?php if($_POST['comm_name']==$id) echo 'selected'; ?>><?php echo $comm; ?></option>
                    <?php
                    endif;
                    endwhile;
                    wp_reset_query();
                    ?>
                </select>
                <select name="sqft_range">
                    <option value="0">SqFt Range</option>
                    <option value="1,1499" <?php if($_POST['sqft_range']=='1,1499') echo 'selected'; ?>>1 - 1,499</option>
                    <option value="1500,1999" <?php if($_POST['sqft_range']=='1500,1999') echo 'selected'; ?>>1,500 - 1,999</option>
                    <option value="2000,2499" <?php if($_POST['sqft_range']=='2000,2499') echo 'selected'; ?>>2,000 - 2,499</option>
                    <option value="2500,2999" <?php if($_POST['sqft_range']=='2500,2999') echo 'selected'; ?>>2,500 - 2,999</option>
                    <option value="3000,10000" <?php if($_POST['sqft_range']=='3000,10000') echo 'selected'; ?>>3,000 +</option>
                </select>
				<select name="min_beds">
                    <option value="0">Min Beds</option>
                    <option <?php if($_POST['min_beds']==1) echo 'selected'; ?>>1</option>
                    <option <?php if($_POST['min_beds']==2) echo 'selected'; ?>>2</option>
                    <option <?php if($_POST['min_beds']==3) echo 'selected'; ?>>3</option>
                    <option <?php if($_POST['min_beds']==4) echo 'selected'; ?>>4</option>
                    <option <?php if($_POST['min_beds']==5) echo 'selected'; ?>>5</option>
                    <option <?php if($_POST['min_beds']==6) echo 'selected'; ?>>6</option>
                </select>
				<select name="min_baths">
                    <option value="0">Min Baths</option>
                    <option <?php if($_POST['min_baths']==1) echo 'selected'; ?>>1</option>
                    <option <?php if($_POST['min_baths']==2) echo 'selected'; ?>>2</option>
                    <option <?php if($_POST['min_baths']==3) echo 'selected'; ?>>3</option>
                    <option <?php if($_POST['min_baths']==4) echo 'selected'; ?>>4</option>
                    <option <?php if($_POST['min_baths']==5) echo 'selected'; ?>>5</option>
                    <option <?php if($_POST['min_baths']==6) echo 'selected'; ?>>6</option>
                </select>
                <select name="min_garage">
                    <option value="0">Min Garage</option>
                    <option <?php if($_POST['min_garage']==1) echo 'selected'; ?>>1</option>
                    <option <?php if($_POST['min_garage']==2) echo 'selected'; ?>>2</option>
                    <option <?php if($_POST['min_garage']==3) echo 'selected'; ?>>3</option>
                    <option <?php if($_POST['min_garage']==4) echo 'selected'; ?>>4</option>
                    <option <?php if($_POST['min_garage']==5) echo 'selected'; ?>>5</option>
                    <option <?php if($_POST['min_garage']==6) echo 'selected'; ?>>6</option>
                </select>
                <input type="hidden" name="search" value="true" />
				<input type="submit" value="Filter" class="remove-bottom" />
			</form>
		</div>