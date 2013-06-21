@layout('layouts.master')
@section('content')
<div class="whiteGrad">
    <div class="container">
        <div class="row">
            <div class="w-2col m-2col marginTopDouble marginBottom">
                <h2 class="font36 normal">
                    <span class="dBFont bold"> Search</span> results
                </h2>
                <ul class="flatList">
                    <li><span class="bold">Search Term: </span> "{{$term}}" </li>
                    <li><span class="bold">Total items: </span><a href="#">{{$results['total']}}</a></li>
                    <li><span class="bold">Natural Science items: </span> <a href="#">{{$results['natural_num']}}</a></li>
                    <li><span class="bold">Cultural collections items: </span> <a href="#">{{$results['cultural_num']}}</a></li>
                </ul>
            </div>
            <div class="w-2col m-2col w-last m-last marginTopDouble">
                <p class="font18 alignLeft marginRight"><a href="{{$NewSearch}}"  class="alignLeft sm_bnt orangeGrad boxShadow"><span class="bold">New Search</span></a></p>
                <p class="font18 alignLeft"><a href="{{$RefineSearch}}" class="alignLeft sm_bnt orangeGrad boxShadow"><span class="bold">Refine Existing Search</span> </a></p>
            </div>
        </div>
        <div class="row">
            <div class="w-2col m-2col bb-grey paddingBottom">
                <h3 class="marginBottomHalf marginTopHalf font28 normal">
                    <span class="bold dBFont">Natural History</span> Collection
                </h3>
                <h4>
                    Information Sheets
                </h4>
                
                @if ($results['narrative_natural_list'])
                @foreach ($results['narrative_natural_list'] as $val)
                <div class="box">
                    <img src="{{$val['getImageUrl']}}">

                    <div class="box-body">
                        <p class="box-heading">
                            <a href="/info/{{$val['irn']}}">{{$val['NarTitle']}}</a>
                        </p>
                        <p>
                            {{$val['SummaryData']}}
                        </p>
                    </div>
                </div> <!-- Box closed -->
                @endforeach
               @endif 
                
                
            </div>
            <div class="w-2col m-2col w-last m-last bb-grey paddingBottom">
                <h3 class="marginBottomHalf marginTopHalf font28 normal">
                    <span class="bold dBFont">Cultural</span> Collection
                </h3>
                <h4>
                    Information Sheets
                </h4>
 
                @if ($results['narrative_cultural_list'])
                @foreach ($results['narrative_cultural_list'] as $val)                
                <div class="box">

                    <img src="{{$val['getImageUrl']}}">

                    <div class="box-body">
                        <p class="box-heading">
                             <a href="/info/{{$val['irn']}}">{{$val['NarTitle']}}</a>
                        </p>
                        <p>
                             {{$val['SummaryData']}}
                        </p>
                    </div>
                </div>
               @endforeach
               @endif 
                
            </div> <!-- w-2col closed -->
        </div> <!-- row closed -->
        <div class="row">
        
        	@if ($results['object_natural_list'])
        
            <div class="w-2col m-2col marginBottomDouble paddingBottom">
                <h4>
                    Objects
                </h4>
                <ul class="objectList">
                	@foreach ($results['object_natural_list'] as $val)
                    <li><a href="/object/{{$val['irn']}}">{{$val['WebSummaryData']}}</a></li>
                	@endforeach
                </ul>
            </div>
       	   @endif     
           
           @if ($results['object_cultural_list']) 
            <div class="w-2col m-2col w-last m-last marginBottomDouble paddingBottom">
                <h4>
                    Objects
                </h4>
                <ul class="objectList">
                	@foreach ($results['object_cultural_list'] as $val)
                    <li><a href="/object/{{$val['irn']}}">{{$val['WebSummaryData']}}</a></li>
                    @endforeach
                </ul>
            </div>
           @endif 
        </div>

    </div>	 <!-- container -->
</div>	<!-- whiteGrad -->
@endsection