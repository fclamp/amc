@layout('layouts.master')
@section('content')
<div class="whiteGrad">
    <div class="container">
        <div class="row">
            <div class="w-content m-content sm-content s-content marginTopDouble marginBottom">
                <h2 class="font30 marginBottomHalf">
                    <span class="font10 dFont uppercase block">Registration Number</span>
                    <span class=" dBFont"> {{$results['objectId']}} </span>
                </h2>
                <img id="fristImageShow"src="{{$results['firstImage']}}">
                

                    <div class="w-feature-gutter s3-feature-gutter arrow-left"><a href="javascript:void(0);" class="main_left_arrow">  @if($results['images']){{ HTML::image('images/arrow_left.png'); }} @endif</a> </div>
			        <div class="my-list-thumb">
			        <div class="my-really-thumb" style="width:3000px;position:relative;">


						<div class="my-really-thumbbox">
			           <?php $class='';$i=0;$j=0;$num=count($results['images'])-1;?>
			            <?php foreach ($results['images'] as $k=>$val){?>
			            
			            
			            <?php 
			            $i++;$j++;
			            if($i==6){
			            	$class='s3-last w-last m-last sm-last s-last';
			            	$i=0;
			            }else
			            {
			            	$class = '';
			            }
			            ?>
			            
			            <div class="w-feature-6 s3-feature <?php echo $class;?>">
			                <a href="javascript:void(0);" class="selectImageClick" data-src="<?php echo $val['getImageUrl'];?>"><img data-photoCopy="<?php echo $val['photoCopy'];?>" data-photoGrapher="<?php echo $val['photoGrapher'];?>" src="<?php echo $val['getImageUrl'];?>"></a>
			             </div>
			             <?php 
			                 if($j==6 and $num !=$k)
			                  {
			                     	$j=0;
			              ?>
			               </div>
			               <div class="my-really-thumbbox">
			               <?php }elseif($num==$k){?>
			               </div>
			             <?php }?>			             
			             
			             
			             
			             
			            <?php }?>
			            
			            
			            
			            
			            
			            

					</div>
                    </div>
                    <div class="w-feature-gutter s3-feature-gutter arrow-right"><a href="javascript:void(0);" class="main_right_arrow"> @if($results['images']){{ HTML::image('images/arrow_right.png'); }}@endif</a>  </div>
                
                
                
                
                
                <div class="row marginTopDouble">
	                <h2><span class="font10 dFont block">Object ID: <span style="font-weight:normal;">{{ $results['objectId'] }}</span> </span></h2>
                    <h2><span class="font10 dFont block">Object Name: <span style="font-weight:normal;">{{ $results['objectName'] }}</span></span> </h2>
                    <h2><span class="font10 dFont block">Photograph Copyright: <span style="font-weight:normal;">{{ $results['photoCopy'] }}</span></span></h2>
                    <h2><span class="font10 dFont block">Photographer: <span style="font-weight:normal;">{{ $results['photoGrapher'] }}</span></span></h2>

                    <p> {{ $results['content'] }} </p>
                </div>
            </div>

            <div class="w-aside m-aside sm-aside s-aside w-last m-last marginTopDouble paddingTopDouble">
                <h2 class="normal marginLeftSpec marginBottomHalf">
                    <span class="bold dBFont">Browse</span> related objects
                </h2>
                
                	@if($results['relatedObjects'])
                    <div class="w-related-gutter m-related-gutter sm-related-gutter s-related-gutter s3-feature-gutter arrow-left">@if($results['relatedObjects'])<a href="javascript:void(0);" class="related_left_arrow"> {{ HTML::image('images/arrow_left.png'); }}</a>@endif  </div>
			        <div class="my-list-related">
			        <div class="my-really-related" style="width:3000px;position:relative;">
								
								<div class="my-related-conter">
						            <?php $class='';$i=0;$j=0;$num=count($results['relatedObjects'])-1;?>
						            <?php foreach ($results['relatedObjects'] as $k=>$val){?>
						            
						            
						            <?php 
						            $i++;$j++;
						            if($i==4){
						            	$class='w-last sm-last';
						            	$i=0;
						            }else
						            {
						            	$class = '';
						            }
						            ?>
						            
			                        <div class="w-related-4 m-related-3 sm-related-2 s-related-6 s3-feature <?php echo $class;?>">
			                          <img src="<?php echo $val['getImageUrl'];?>">
			                            <p>
			                                <a href="/object/{{$val['irn']}}"><?php echo $val['SumRegNum'];?></a>
			                            </p>
			                        </div>
			                        
			                        <?php 
			                        	if($j==12 and $num !=$k)
			                        	{
			                     			$j=0;
			                        ?>
			                        </div>
			                        <div class="my-related-conter">
			                        <?php }elseif($num==$k){?>
			                        </div>
			                        <?php }?>
			                        
			                        
			                        
						            <?php }?>								
								
								
												
								
						                       
					</div>
			        </div>
                    <div class="w-related-gutter m-related-gutter sm-related-gutter s-related-gutter s3-feature-gutter arrow-right"> @if($results['relatedObjects'])<a href="javascript:void(0)" class="related_right_arrow"> {{ HTML::image('images/arrow_right.png'); }}</a>@endif  </div>
                	@endif
                	
                	
                	
                
                <div class="marginLeftSpec">
                    <h3 class="marginBottomHalf normal">
                        <span class="bold dBFont">Related</span> information sheets
                    </h3>
                    <ul class="infosheetsList bold">
                    @foreach ($results['relatedNarratives'] as $val)
                        <li><a href="/info/{{$val['irn']}}">{{$val['title']}}</a></li>
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>

    </div>	 <!-- container -->
</div>	<!-- whiteGrad -->

<script>

$(function(){


	/**
	* Show Big Image
	*
	*
	**/
	$(".selectImageClick").live('click',function(){
	 	var url = $(this).attr('data-src');
	 	$('#fristImageShow').attr('src',url);					 	
		return false;
	});		
	
	

	/**
	*Information Sheet Main Objects
	*
	*/
	var MainCurPage = 1;
	var MainPageSize = 6;
	var MaindNum = $('.w-feature-6').length;

	var MainPages = Math.ceil(MaindNum / MainPageSize);
	var MainShowBox = $('.my-really-thumb');
	
	$('.main_right_arrow').click(function(){
	    if (!MainShowBox.is(':animated')) { 

			if(MainCurPage==MainPages)
			{
				return false;
			}
			
			MainShowBox.animate({
	            left: '-=' + 631
	        }, 500);
			MainCurPage++;
		}	
	});

	$('.main_left_arrow').click(function(){
	    if (!MainShowBox.is(':animated')) { 

			if(MainCurPage==1)
			{
				return false;
			}
			
			MainShowBox.animate({
	            left: '+=' + 631
	        }, 500);
			MainCurPage--;
		}	
	});

	


	

	/**
	*Information Sheet Related Objects
	*
	*/
	var RelatedCurPage = 1;
	var RelatedPageSize = 12;
	var RelatedNum = $('.w-related-4').length;

	var RelatedPages = Math.ceil(RelatedNum / RelatedPageSize);
	var RelatedShowBox = $('.my-really-related');
	
	$('.related_right_arrow').click(function(){
	    if (!RelatedShowBox.is(':animated')) { 

			if(RelatedCurPage==RelatedPages)
			{
				return false;
			}
			
			RelatedShowBox.animate({
	            left: '-=' + 351
	        }, 500);
			RelatedCurPage++;
		}	
	});

	$('.related_left_arrow').click(function(){
	    if (!RelatedShowBox.is(':animated')) { 

			if(RelatedCurPage==1)
			{
				return false;
			}
			
			RelatedShowBox.animate({
	            left: '+=' + 351
	        }, 500);
			RelatedCurPage--;
		}	
	});
});	

</script>
@endsection