<?php

    $rows = get_sub_field('slides');
    $count = count($rows);
    $title_attr = preg_replace('/[^A-Za-z0-9]/', '', strtolower(str_replace(' ', '', get_sub_field('title'))));  
    $class_slider = get_sub_field('cl_block');
?>

<?php if( have_rows('slides') ): ?>

    <div id="carousel-<?=$title_attr?>" class="block-addon carousel slide">
        <!-- Indicators -->
        <div class="<?php echo $class_slider? 'v-slider' : 'horizontal-slider'?> ">
        <?php while ( have_rows('slides') ) : the_row(); ?>
            <div class="item-slide" style="<?php fcb_block_wrapper_styles(); ?>">
                <div class="wrap">
                    <div class="carousel-content">
                        <div class="carousel-content-inner">
                            <?php cfb_template('blocks/parts/block-media', get_row_layout()); ?>
                            <?php cfb_template('blocks/parts/block-content', get_row_layout()); ?>
                            <div class="carousel-caption">
                                <?php the_sub_field('title'); ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        <?php endwhile; ?>
        </div>
    </div>

<?php endif; ?>