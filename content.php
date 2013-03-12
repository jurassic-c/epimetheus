        <article role="article" id="post-<?php the_ID(); ?>" class="">

          <?= the_title('<h3>', '</h3>', false) ?>
          <h6>Written by <a href="#"><?= get_the_author() ?></a> on <? the_date() ?>.</h6>

          <div class="row">
          	<div class="large-12 columns">
            	<? the_content() ?>
        	</div>
          </div>

        </article>
        <hr />