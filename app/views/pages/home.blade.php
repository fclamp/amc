@layout('layouts.master')
@section('content')
<div class="whiteGrad paddingLeft paddingRight">
    <div class="container">
        <div class="row">
            <div class="w-3col marginTopDouble marginBottomDouble">
                <p class="font29 lineHeight12">
                    Explore millions of specimens and objects from the Australian Museum <span class="dBFont bold">natural science &amp; cultural collections.</span>
                </p>
            </div>
        </div>

        <div class="explore-wrap">
            <div class="row">
                <div class="full-col w-last m-last">
                    <ul class="inlineListBnt marginNone font22">
                        <li class="bnt active-tab"><a href="#explore" id="explore"><span class="bold">Explore</span> the collection</a></li>
                        <li class="bnt"><a href="#search" id="search" class="orangeGrad boxShadow"><span class="bold">Search</span> the collection</a></li>
                    </ul>
                </div>
            </div>

            <div class="row lightBlue paddingTopDouble paddingBottomDouble border-radius234">
                <div class="w-explore m-explore">
                    <h2 class="normal marginBottomHalf">
                        <span class="dBFont bold">Natural History</span> Collection
                    </h2>

                    @foreach ($results['natural_list'] as $val)
                    <div class="box-wrap">
                        <img src="{{$val['getImageUrl']}}" class="my-show-image-thumb">
                        <p><a href="/info/{{$val['irn']}}"><?php echo substr($val['NarTitle'],0,10);?></a></p>
                    </div>
                    @endforeach

                </div>

                <div class="w-explore m-explore w-last m-last	">
                    <h2 class="normal marginBottomHalf">
                        <span class="dBFont bold">Cultural</span> Collection
                    </h2>
                    @foreach ($results['cultural_list'] as $val)
                    <div class="box-wrap">
                        <img src="{{$val['getImageUrl']}}" class="my-show-image-thumb">
                        <p><a href="/info/{{$val['irn']}}"><?php echo substr($val['NarTitle'],0,10);?></a></p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div><!-- explore wrap closed -->

        <a name="search"/>
        <div class="form-wrap">
            <div class="row">
                <div class="ful-box w-last m-last">
                    <ul class="inlineListBnt marginNone font22">
                        <li class="bnt"><a href="#explore" id="explore2"  class="orangeGrad boxShadow"><span class="bold">Explore</span> the collection</a></li>
                        <li class="bnt active-tab"><a href="#search" id="search2"><span class="bold">Search</span> the collection</a></li>
                    </ul>
                </div>
            </div>
            <div class="row lightBlue paddingTopDouble">
                <div class="full-col w-last m-last">

                    <form action="{{ URL::to('search/results'); }}" method="get" class="search-form marginTopDouble">
                        <div class="row">
                            <div class="ful-box">
                                <label for="KeyWords" class="font18 bold">Keywords</label>
                                <div class="box-right">
                                    <input type="text" name="KeyWords" value="{{$KeyWords}}">
                                    <p>
                                        <em>eg. Australian frogs</em>
                                    </p>
                                </div>
                            </div>
                            <div class="ful-box">
                                <label for="Date" class="font18 bold">Date</label>
                                <div class="box-right">
                                    <input type="text" name="Date" value="{{$Date}}">
                                    <p>
                                        <em>eg. Date collected, Date donated</em>
                                    </p>
                                </div>
                            </div>
                            <div class="ful-box">
                                <label for="Location" class="font18 bold">Location</label>
                                <div class="box-right">
                                    <input type="text" name="Location" value="{{$Location}}">
                                    <p>
                                        <em>eg. New South Wales</em>
                                    </p>
                                </div>
                            </div>
                            <div class="ful-box">
                                <label for="Registration" class="font18 bold">Registration Number</label>
                                <div class="box-right">
                                    <input type="text" name="Registration" value="{{$Registration}}">
                                    <p>
                                        <em>eg. E039560-002</em>
                                    </p>
                                </div>
                            </div>
                            <div class="ful-box">
                                <label for="Collection" class="font18 bold">Choose a collection</label>
                                <div class="box-right">
                                    <select name="Collection" class="font14">
                                        <option value="0">All</option>
                                        <option value="natural" @if ($Collection == 'natural') selected="selected" @endif>Natural Science</option>
                                        <option value="cultural" @if ($Collection == 'cultural') selected="selected" @endif>Cultural Collection</option>
                                    </select>
                                    <p>
                                        <em>eg. Natural Science or Cultural Collection</em>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="s3-feature overflow marginTopDouble">
                            <div class="alignLeft form-2">
                                <input type="checkbox" class="searchInput alignLeft marginRight" value="true" name="ImagesOnly" @if ($ImagesOnly == 'true') checked="checked" @endif>
                                <p class="bFont">Restrict to items with images</p>
                            </div>
                        </div>
                        <div class="s3-feature overflow paddingBottomDouble">
                            <div class="form-2 alignLeft">
                                <input type="submit" value="Submit" class="search_bnt orangeGrad bold font18 boxShadow" id="Submit">
                            </div>
                        </div>
                    </form>
                </div>
            </div> <!-- Row one -->
        </div> <!-- Form Wrap -->
    </div>
</div>
@endsection