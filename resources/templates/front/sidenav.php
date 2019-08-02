  <div class="col-md-3">
                <p class="lead">Shop Name</p>
                <div class="list-group">
				<?php
					$select_category_query="SELECT * FROM `categories`";
					$select_category = $db->prepare($select_category_query);
					if($select_category->execute()){
						while($row_category = $select_category->fetch(PDO::FETCH_OBJ)){
							echo "<a href=\"category.html\" class=\"list-group-item\">{$row_category->cat_title}</a>";
						}
					} //if($select_category->execute())
				?>
                    
                    <?php /* <a href="#" class="list-group-item">Category 2</a>
                    <a href="#" class="list-group-item">Category 3</a> */ ?>
                </div>
            </div>