
<div class="col-lg-3 col-md-6">
    <div class="card">
    <div class="body" style="    text-align-last: center;">
        <h6 class="number count-to" data-from="0" data-to="128" data-speed="2000" data-fresh-interval="700">
            Showing Data Of :- <u>Whole Company</u>
        </h6>
        <hr>
        <form method="post" action="{{ url('/siteDashboard') }}">
            @csrf
            <select class="form-control show-tick" data-live-search="true" required name="display_site">
                <option selected value=""> Change Display Site</option>
                @foreach ($sitesnameadd as $dd)
                    <option value="{{ $dd->id }}">{{ $dd->name }}</option>
                @endforeach
            </select>

            <button type="submit" class="btn btn-primary  btn-round waves-effect"
                style="color:white !important;">Search</button>
        </form>
        <hr>
        <p>Select a site above to view detailed data for a specific site.</p>
        <br>
        <a href="{{url('/generateBackup')}}" >Generate Backup</a>
    </div>

</div>
</div>