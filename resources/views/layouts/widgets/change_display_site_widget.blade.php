<div class="col-lg-3 col-md-6">
    <div class="card">
        <div class="body" style="text-align-last: center;">
            @php $site_details = getSiteDetailsById($id);@endphp
            <h6 class="number count-to" data-from="0" data-to="128" data-speed="2000" data-fresh-interval="700">
                Showing Data Of :- <u><?= $site_details->name ?></u>
            </h6>
            <hr>
            @php
                $role_id = session()->get('role');
                $role_details = getRoleDetailsById($role_id);
                $visiblity_at_site = $role_details->visiblity_at_site;

            @endphp
            @if ($visiblity_at_site != 'current')
                <form method="post" action="{{ url('/siteDashboard') }}">
                    @csrf
                    <select class="form-control show-tick" data-live-search="true" required name="display_site">
                        <option selected value=""> Change Display Site</option>
                        @php
                            $sitesnameadd = getallsites();
                        @endphp
                        @foreach ($sitesnameadd as $dd)
                            <option value="{{ $dd->id }}">{{ $dd->name }}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn btn-primary  btn-round waves-effect"
                        style="color:white !important;">Search</button>
                </form>
                <hr>
                <a href="{{ url('/dashboard') }}" class="btn btn-primary  btn-round waves-effect"
                    style="color:white !important;">Complete Company Dashboard</a>
            @endif
        </div>
    </div>
</div>
