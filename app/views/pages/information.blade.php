@layout('layouts.master')
@section('content')
<div class="whiteGrad">
<div class="container">
<div class="row">
<div class="w-content m-content sm-content s-content marginTopDouble marginBottom">
    <h2 class="font30 marginBottomHalf">
        <span class="font10 dFont uppercase block">Information Sheet</span>
        <span class=" dBFont"> {{$results['title']}}</span>
    </h2>
    
        <div class="w-feature-gutter s3-feature-gutter arrow-left"> @if($results['mainObjectList'])<a href="javascript:void(0);" class="main_left"> {{ HTML::image('images/arrow_left.png'); }}</a>@endif </div>
        <div class="my-list-conter">
        <div class="my-really" style="position:relative;width:30000px;">
          
          <div class="my-contener">
            <!-- Row -->
            
            <?php $class='';$i=0;$j=0;$k=0;$num=count($results['mainObjectList']);?>
            <?php foreach ($results['mainObjectList'] as $val){?>
            
            
            <?php 
            $i++;$j++;$k++;
            if($i==6){
            	$class='s3-last w-last m-last sm-last s-last';
            	$i=0;
            }else
            {
            	$class = '';
            }
            ?>
            
            <div class="w-feature-6 s3-feature <?php echo $class;?>">
                  <img src="<?php echo $val['getImageUrl'];?>" class="my-info-image-thumb">
                <p>
                    <a href="/object/<?php echo $val['irn'];?>"><?php echo $val['regNum'];?></a>
                </p>
            </div>
                        <?php 
                        	if($j==18 and $num !=$k)
                        	{
                     			$j=0;
                        ?>
                        </div>
                        <div class="my-contener">
                        <?php }elseif($num==$k){?>
                        </div>
                        <?php }?>            
            
            
            
            
            
            <?php }?>
            
            
            
            
            
            <!-- Row images -->  
            
        </div>
        </div>
        <div class="w-feature-gutter s3-feature-gutter arrow-right"> @if($results['mainObjectList'])<a href="javascript:void(0)" class="main_right"> {{ HTML::image('images/arrow_right.png'); }}</a>@endif </div>
    
    <div class="row marginTopDouble">
    	<p><b>{{$results['mainObjectNum']}} Objects</b></p>
    	<p>{{$results['content']}}</p>
    </div>
</div>

<div class="w-aside m-aside sm-aside s-aside w-last m-last marginTopDouble">
    <h2 class="normal marginLeftSpec marginBottomHalf">
        <span class="bold dBFont">Browse</span> related objects
    </h2>
    
        <div class="w-related-gutter m-related-gutter sm-related-gutter s-related-gutter s3-feature-gutter arrow-left"> @if($results['relatedObjects'])<a href="javascript:void(0);" class="related_left_arrow"> {{ HTML::image('images/arrow_left.png'); }}</a>@endif  </div>
        <div class="my-list-related">
        <div class="my-really-related" style="width:30000px;position:relative;">
					
								<div class="my-related-conter">
						            <?php $class='';$i=0;$j=0;$k=0;$num=count($results['relatedObjects']);?>
						            <?php foreach ($results['relatedObjects'] as $val){?>
						            
						            
						            <?php 
						            $i++;$j++;$k++;
						            if($i==4){
						            	$class='w-last sm-last';
						            	$i=0;
						            }else
						            {
						            	$class = '';
						            }
						            ?>
						            
			                        <div class="w-related-4 m-related-3 sm-related-2 s-related-6 s3-feature <?php echo $class;?>">
			                            <img src="<?php echo $val['getImageUrl'];?>" class="my-info-image-thumb">
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
        <div class="w-related-gutter m-related-gutter sm-related-gutter s-related-gutter s3-feature-gutter arrow-right"> @if($results['relatedObjects'])<a href="javascript:void(0)" class="related_right_arrow"> {{ HTML::image('images/arrow_right.png'); }}</a>@endif </div>
    
    <div class="marginLeftSpec">
        <h3 class="marginBottomHalf normal">
            <span class="bold dBFont">Related</span> information sheets
        </h3>
        <ul class="infosheetsList bold">
         @foreach ($results['narrativeList'] as $val)
            <li><a href="/info/{{$val['irn']}}">{{$val['NarTitle']}}</a></li>
         @endforeach   
        </ul>
    </div>
</div>
</div>

<script>
$(function(){

	/**
	*Information Sheet Main Objects
	*
	*/
    var curPage = 1;
    var pageSize = 18;
    var num = $('.w-feature-6').length;
    var pages = Math.ceil(num / pageSize);
    var showBox = $('.my-really');
	$('.main_right').click(function(){
        if (!showBox.is(':animated')) { 

    		if(curPage==pages)
    		{
    			return false;
    		}
    		
    		showBox.animate({
                left: '-=' + 625
            }, 500);
    		curPage++;
    	}	
	});
	
	$('.main_left').click(function(){

        if (!showBox.is(':animated')) { 
    		if(curPage==1)
    		{
    			return false;
    		}
    	
    		showBox.animate({
                left: '+=' + 625
            }, 500);
    		curPage--;	 	
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

</div>	 <!-- container -->
</div>	<!-- whiteGrad -->
@endsection