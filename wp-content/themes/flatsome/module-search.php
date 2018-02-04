<?php
/**
 * The template for displaying search forms in flatsome
 *
 * @package flatsome
 */

$placeholder = __( 'Search', 'woocommerce' ).'&hellip;';
// if(get_theme_mod('search_placeholder')) $placeholder = get_theme_mod('search_placeholder');
HBImporter::helper('params','html');
$input = HBFactory::getInput();
$class_types = HBParams::get('class_type','arrayObject');
array_unshift($class_types, (object)array('value'=>'','text'=>'------ Chọn lớp -----'));

$degree_types = HBParams::get('degree_type','arrayObject');
array_unshift($degree_types, (object)array('value'=>'','text'=>'------ Trình độ chuyên môn -----'));

$subject_types = HBParams::get('subject_type','arrayObject');
array_unshift($subject_types, (object)array('value'=>'','text'=>'------ Trình môn học -----'));

$districts = HBParams::get_districts();
array_unshift($districts, (object)array('matp'=>'','name'=>'------ Chọn thành phố -----'));

$exp_type = HBParams::get_exp_type();

HBImporter::model('teacher');
$model = new HBModelTeacher();
$items = $model->getItems();

$total= count($items);
$number_result = array();
// debug($items);die;
foreach($exp_type as $e=>$type){
	$number_result[$e] = array_filter($items,function($obj) use ($e) {return $obj->exp_type==$e;});
}

// debug($class_types);
?>

	
<div class="container">
	<form method="get" class="searchform" action="<?php echo esc_url( get_page('')->page_name ); ?>" role="search">
	    <div class="row filterBox">
	        <div class="col medium-3">
	            <?php echo HBHtml::select($class_types, 'class_type', 'class="form-control filterCss"', 'value', 'text',$input->get('class_type'));?>
	            <?php echo HBHtml::select($degree_types, 'degree_type', 'class="form-control filterCss"', 'value', 'text',$input->get('degree_type'));?>            
	        </div>
	        <div class="col medium-3">
	        	<?php echo HBHtml::select($subject_types, 'subject_type', 'class="form-control filterCss"', 'value', 'text',$input->get('subject_type'));?>
	        	<?php echo HBHtml::select($districts, 'district', 'class="form-control filterCss"', 'matp', 'name',$input->get('district_id'));?>
	        </div>
	        <div class="col medium-3">
	            <?php echo HBHtml::select(HBParams::get('gender','arrayObject'), 'gender', 'class="form-control filterCss"', 'value', 'text',$input->get('gender'),'gender','------ Chọn giới tính -----');?>
	            <?php echo HBHtml::select(HBParams::get_provinces(), 'province_id', 'class="form-control filterCss"', 'maqh', 'name',$input->get('province_id'),'province_id','------ Quận/Huyện -----');?>
	           
	        </div>
	        <div class="col medium-3">
	            <button type="submit" class="button  " >Tìm kiếm</button>
	        </div>
	    </div>
	</form>
    <div class="row resultBox">
        <h2 class="text-center">Kết quả tìm kiếm</h2>
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#home">Tất cả (<?php echo $total?>)</a></li>
            <?php 
			foreach($exp_type as $e=>$type){?>
				<li><a data-toggle="tab" href="#menu<?php echo $e?>"><?php echo $type?> (<?php echo count($number_result[$e])?>)</a></li>				
			<?php }?>
        </ul>
		<?php if(empty($items)){?>
		<?php }else{?>
        <div class="tab-content">        	
            <div id="home" class="tab-pane fade in active">
               <?php foreach($items as $item){?>
               		<?php echo HBHelper::renderLayout('teacher-list', $item)?>
               <?php }?>
            </div>

			<?php 
			foreach($exp_type as $e=>$type){?>
				<div id="menu<?php echo $e?>" class="tab-pane fade">
					<?php foreach($number_result[$e] as $item){?>
						 <?php echo HBHelper::renderLayout('teacher-list', $item)?>
					<?php }?>
				</div>
								
			<?php }?>

            <div id="menu3" class="tab-pane fade">
                <h3>Menu 3</h3>
                <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
            </div>
        </div>
        <?php }?>
    </div>


</div>



<style>
    .class{
        width: 100%;
    }
    .filterCss{
        margin-bottom: 10px;
    }
    .filterBox{
        margin-top: 30px;margin-bottom: 30px;
    }
    .resultBox{

    }
    .resultItem{
        margin-top: 20px;
    }
    ul li {
    }
    #colorstar { color: #ee8b2d;}
    .badForm {color: #FF0000;}
    .goodForm {color: #00FF00;}
    .evaluation { margin-left:0px;}
    .priceBox{
        margin-top: 10px;
    }

</style>

<script>
    // Starrr plugin (https://github.com/dobtco/starrr)
    var __slice = [].slice;

    (function($, window) {
        var Starrr;

        Starrr = (function() {
            Starrr.prototype.defaults = {
                rating: void 0,
                numStars: 5,
                change: function(e, value) {}
            };

            function Starrr($el, options) {
                var i, _, _ref,
                    _this = this;

                this.options = $.extend({}, this.defaults, options);
                this.$el = $el;
                _ref = this.defaults;
                for (i in _ref) {
                    _ = _ref[i];
                    if (this.$el.data(i) != null) {
                        this.options[i] = this.$el.data(i);
                    }
                }
                this.createStars();
                this.syncRating();
                this.$el.on('mouseover.starrr', 'span', function(e) {
                    return _this.syncRating(_this.$el.find('span').index(e.currentTarget) + 1);
                });
                this.$el.on('mouseout.starrr', function() {
                    return _this.syncRating();
                });
                this.$el.on('click.starrr', 'span', function(e) {
                    return _this.setRating(_this.$el.find('span').index(e.currentTarget) + 1);
                });
                this.$el.on('starrr:change', this.options.change);
            }

            Starrr.prototype.createStars = function() {
                var _i, _ref, _results;

                _results = [];
                for (_i = 1, _ref = this.options.numStars; 1 <= _ref ? _i <= _ref : _i >= _ref; 1 <= _ref ? _i++ : _i--) {
                    _results.push(this.$el.append("<span class='glyphicon .glyphicon-star-empty'></span>"));
                }
                return _results;
            };

            Starrr.prototype.setRating = function(rating) {
                if (this.options.rating === rating) {
                    rating = void 0;
                }
                this.options.rating = rating;
                this.syncRating();
                return this.$el.trigger('starrr:change', rating);
            };

            Starrr.prototype.syncRating = function(rating) {
                var i, _i, _j, _ref;

                rating || (rating = this.options.rating);
                if (rating) {
                    for (i = _i = 0, _ref = rating - 1; 0 <= _ref ? _i <= _ref : _i >= _ref; i = 0 <= _ref ? ++_i : --_i) {
                        this.$el.find('span').eq(i).removeClass('glyphicon-star-empty').addClass('glyphicon-star');
                    }
                }
                if (rating && rating < 5) {
                    for (i = _j = rating; rating <= 4 ? _j <= 4 : _j >= 4; i = rating <= 4 ? ++_j : --_j) {
                        this.$el.find('span').eq(i).removeClass('glyphicon-star').addClass('glyphicon-star-empty');
                    }
                }
                if (!rating) {
                    return this.$el.find('span').removeClass('glyphicon-star').addClass('glyphicon-star-empty');
                }
            };

            return Starrr;

        })();
        return $.fn.extend({
            starrr: function() {
                var args, option;

                option = arguments[0], args = 2 <= arguments.length ? __slice.call(arguments, 1) : [];
                return this.each(function() {
                    var data;

                    data = $(this).data('star-rating');
                    if (!data) {
                        $(this).data('star-rating', (data = new Starrr($(this), option)));
                    }
                    if (typeof option === 'string') {
                        return data[option].apply(data, args);
                    }
                });
            }
        });
    })(window.jQuery, window);

    $(function() {
        return $(".starrr").starrr();
    });

    $( document ).ready(function() {

        var correspondence=["","Really Bad","Bad","Fair","Good","Excelent"];

        $('.ratable').on('starrr:change', function(e, value){

            $("#countBox").show();
            $(this).closest('.evaluation').children('#count').html(value);
            $(this).closest('.evaluation').children('#meaning').html(correspondence[value]);

            var currentval=  $(this).closest('.evaluation').children('#count').html();

            var target=  $(this).closest('.evaluation').children('.indicators');
            target.css("color","black");
            target.children('.rateval').val(currentval);
            target.children('#textwr').html(' ');


            // if(value<3){
            //     target.css("color","red").show();
            //     target.children('#textwr').text('What can be improved?');
            // }else{
            //     if(value>3){
            //         target.css("color","green").show();
            //         target.children('#textwr').html('What was done correctly?');
            //     }else{
            //         target.hide();
            //     }
            // }

        });





        $('#hearts-existing').on('starrr:change', function(e, value){
            $('#count-existing').html(value);
        });
    });





    $(function () {
        $('.button-checkbox').each(function () {

            // Settings
            var $widget = $(this),
                $button = $widget.find('button'),
                $checkbox = $widget.find('input:checkbox'),
                color = $button.data('color'),
                settings = {
                    on: {
                        icon: 'glyphicon glyphicon-check'
                    },
                    off: {
                        icon: 'fa fa-square-o'
                    }
                };

            // Event Handlers
            $button.on('click', function () {
                $checkbox.prop('checked', !$checkbox.is(':checked'));
                $checkbox.triggerHandler('change');
                updateDisplay();
            });
            $checkbox.on('change', function () {
                updateDisplay();
            });

            // Actions
            function updateDisplay() {
                var isChecked = $checkbox.is(':checked');

                // Set the button's state
                $button.data('state', (isChecked) ? "on" : "off");

                // Set the button's icon
                $button.find('.state-icon')
                    .removeClass()
                    .addClass('state-icon ' + settings[$button.data('state')].icon);

                // Update the button's color
                if (isChecked) {
                    $button
                        .removeClass('btn-default')
                        .addClass('btn-' + color + ' active');
                }
                else {
                    $button
                        .removeClass('btn-' + color + ' active')
                        .addClass('btn-default');
                }
            }

            // Initialization
            function init() {

                updateDisplay();

                // Inject the icon if applicable
                if ($button.find('.state-icon').length == 0) {
                    $button.prepend('<i class="state-icon ' + settings[$button.data('state')].icon + '"></i> ');
                }
            }
            init();
        });
    });


</script>

