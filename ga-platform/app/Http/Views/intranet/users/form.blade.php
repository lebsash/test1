@section('content')
<div class="row text-left">
    <form method="POST" action="{{ config('app.url-gai') }}/users/form/{{ (isset($id) ? $id : '' ) }}/" role="form">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="UserID" value="{{ (isset($user['UserID']) ? $user['UserID'] : '' ) }}">
        @if (!isset($created))
        @if (isset($updated))
            <div class="col-md-12 alert alert-success">
                {{ $updated }}
            </div>
        @endif
        <div class="col-md-12">
            <h4>{{ (isset($id) ? 'Edit' : 'Create') }} User Form</h4>
            @if (isset($validationErrors) && count($validationErrors))
                <div class="col-sm-10 col-sm-offset-0">
                <div class="alert alert-warning">
                @foreach ($validationErrors as $error)
                    {{ $error }}<br>
                @endforeach
                </div>
                </div>
                <div class="clearfix"></div>
            @endif
            @if (isset($user['UserID']))
            <div class="col-md-12 alert alert-success">
                <div class="col-md-6">
                    <p>User ID: <strong>{{ $user['UserID'] }}</strong></p>
                    <p>Name: <strong>{{ $user['Name'] }}</strong></p>
                    <p>Email: <strong>{{ $user['Email'] }}</strong></p>
                </div>
                <div class="col-md-6">
                    <p>Created Date: <strong>{{ date("M/d/Y g:iA", strtotime($user['Created'])) }}</strong></p>
                    <p>Order Date: <strong>{{ date("M/d/Y g:iA", strtotime($user['OrderDate'])) }}</strong></p>
                    <p>Start Commitment: <strong>{{ date("M/d/Y g:iA", strtotime($user['MonthsCommitmentStart'])) }}</strong></p>
                </div>
            </div>
            @endif
            <div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email</label>
                        <input class="form-control" type="text" name="Email" value="{{ (isset($user['Email']) ? $user['Email'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <input class="form-control" type="text" name="Name" value="{{ (isset($user['Name']) ? $user['Name'] : '' ) }}" />
                    </div>

                    <div class="form-group">
                        <label>URL</label>
                        <input class="form-control" type="text" name="URL" value="{{ (isset($user['URL']) ? $user['URL'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>Points</label>
                        <input class="form-control" type="text" name="Points" value="{{ (isset($user['Points']) ? $user['Points'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>Source</label>
                        <input class="form-control" type="text" name="Source" value="{{ (isset($user['Source']) ? $user['Source'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>IP</label>
                        <input class="form-control" type="text" name="IP" value="{{ (isset($user['IP']) ? $user['IP'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>Location</label>
                        <input class="form-control" type="text" name="Location" value="{{ (isset($user['Location']) ? $user['Location'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>Picture URL</label>
                        <input class="form-control" type="text" name="PictureURL" value="{{ (isset($user['PictureURL']) ? $user['PictureURL'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>Zip</label>
                        <input class="form-control" type="text" name="Zip" value="{{ (isset($user['Zip']) ? $user['Zip'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input class="form-control" type="text" name="Password" value="{{ (isset($user['Password']) ? $user['Password'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>Headline</label>
                        <input class="form-control" type="text" name="Headline" value="{{ (isset($user['Headline']) ? $user['Headline'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>Title</label>
                        <input class="form-control" type="text" name="Title" value="{{ (isset($user['Title']) ? $user['Title'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>Before Location</label>
                        <input class="form-control" type="text" name="BeforeLocation" value="{{ (isset($user['BeforeLocation']) ? $user['BeforeLocation'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>Accepted NDA</label>
                        <input class="form-control" type="text" name="AcceptedNDA" value="{{ (isset($user['AcceptedNDA']) ? $user['AcceptedNDA'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input class="form-control" type="text" name="Phone" value="{{ (isset($user['Phone']) ? $user['Phone'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>Cell</label>
                        <input class="form-control" type="text" name="Cell" value="{{ (isset($user['Cell']) ? $user['Cell'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>Display Email</label>
                        <input class="form-control" type="text" name="DisplayEmail" value="{{ (isset($user['DisplayEmail']) ? $user['DisplayEmail'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>Company Name</label>
                        <input class="form-control" type="text" name="CompanyName" value="{{ (isset($user['CompanyName']) ? $user['CompanyName'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>Company Phone</label>
                        <input class="form-control" type="text" name="CompanyPhone" value="{{ (isset($user['CompanyPhone']) ? $user['CompanyPhone'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>Company Logo</label>
                        <input class="form-control" type="text" name="CompanyLogo" value="{{ (isset($user['CompanyLogo']) ? $user['CompanyLogo'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>Domain Name</label>
                        <input class="form-control" type="text" name="DomainName" value="{{ (isset($user['DomainName']) ? $user['DomainName'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>Months Commitment</label>
                        <input class="form-control" type="text" name="MonthsCommitment" value="{{ (isset($user['MonthsCommitment']) ? $user['MonthsCommitment'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>Email Key</label>
                        <input class="form-control" type="text" name="EmailKey" value="{{ (isset($user['EmailKey']) ? $user['EmailKey'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>Number Of Homes Pre Reg</label>
                        <input class="form-control" type="text" name="NumberOfHomesPreReg" value="{{ (isset($user['NumberOfHomesPreReg']) ? $user['NumberOfHomesPreReg'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>Buyer Site URL</label>
                        <input class="form-control" type="text" name="BuyerSiteURL" value="{{ (isset($user['BuyerSiteURL']) ? $user['BuyerSiteURL'] : '' ) }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Seller Site URL</label>
                        <input class="form-control" type="text" name="SellerSiteURL" value="{{ (isset($user['SellerSiteURL']) ? $user['SellerSiteURL'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>Map Min Longitude</label>
                        <input class="form-control" type="text" name="MapMinLng" value="{{ (isset($user['MapMinLng']) ? $user['MapMinLng'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>Map Max Longitude</label>
                        <input class="form-control" type="text" name="MapMaxLng" value="{{ (isset($user['MapMaxLng']) ? $user['MapMaxLng'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>Map Min Latitude</label>
                        <input class="form-control" type="text" name="MapMinLat" value="{{ (isset($user['MapMinLat']) ? $user['MapMinLat'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>Map Max Latitude</label>
                        <input class="form-control" type="text" name="MapMaxLat" value="{{ (isset($user['MapMaxLat']) ? $user['MapMaxLat'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>Map Start Zoom</label>
                        <input class="form-control" type="text" name="MapStartZoom" value="{{ (isset($user['MapStartZoom']) ? $user['MapStartZoom'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>Landing Page Headline</label>
                        <input class="form-control" type="text" name="LandingPageHeadline" value="{{ (isset($user['LandingPageHeadline']) ? $user['LandingPageHeadline'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>Landing Page Subline</label>
                        <input class="form-control" type="text" name="LandingPageSubline" value="{{ (isset($user['LandingPageSubline']) ? $user['LandingPageSubline'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>KPI Monthly Leads</label>
                        <input class="form-control" type="text" name="KPIMonthlyLeads" value="{{ (isset($user['KPIMonthlyLeads']) ? $user['KPIMonthlyLeads'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>MLS</label>
                        <input class="form-control" type="text" name="MLS" value="{{ (isset($user['MLS']) ? $user['MLS'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>MLS Source IDs</label>
                        <input class="form-control" type="text" name="MLSSourceIDs" value="{{ (isset($user['MLSSourceIDs']) ? $user['MLSSourceIDs'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>MLS Max Listings PerPage</label>
                        <input class="form-control" type="text" name="MLSMaxListingsPerPage" value="{{ (isset($user['MLSMaxListingsPerPage']) ? $user['MLSMaxListingsPerPage'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>Favicon</label>
                        <input class="form-control" type="text" name="favicon" value="{{ (isset($user['favicon']) ? $user['favicon'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>Accountability New Lead Required Call Time</label>
                        <input class="form-control" type="text" name="accountabilityNewLeadRequiredCallTime" value="{{ (isset($user['accountabilityNewLeadRequiredCallTime']) ? $user['accountabilityNewLeadRequiredCallTime'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>Accountability Lead Re-assign New Leads If Missed</label>
                        <input class="form-control" type="text" name="accountabilityLeadReassignNewLeadsIfMissed" value="{{ (isset($user['accountabilityLeadReassignNewLeadsIfMissed']) ? $user['accountabilityLeadReassignNewLeadsIfMissed'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>Accountability Convos To Permanently Own Lead</label>
                        <input class="form-control" type="text" name="accountabilityConvosToPermanentlyOwnLead" value="{{ (isset($user['accountabilityConvosToPermanentlyOwnLead']) ? $user['accountabilityConvosToPermanentlyOwnLead'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>Accountability Lead Reassign Aged Leads If Missed</label>
                        <input class="form-control" type="text" name="accountabilityLeadReassignAgedLeadsIfMissed" value="{{ (isset($user['accountabilityLeadReassignAgedLeadsIfMissed']) ? $user['accountabilityLeadReassignAgedLeadsIfMissed'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>Accountability Required Response Time After Re-assigned</label>
                        <input class="form-control" type="text" name="accountabilityRequiredResponseTimeAfterReassigned" value="{{ (isset($user['accountabilityRequiredResponseTimeAfterReassigned']) ? $user['accountabilityRequiredResponseTimeAfterReassigned'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>Accountability New Lead Reassign If Missed</label>
                        <input class="form-control" type="text" name="accountabilityNewLeadReassignIfMissed" value="{{ (isset($user['accountabilityNewLeadReassignIfMissed']) ? $user['accountabilityNewLeadReassignIfMissed'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>Accountability Add Minutes Attempt 1</label>
                        <input class="form-control" type="text" name="accountabilityAddMinutesAttempt1" value="{{ (isset($user['accountabilityAddMinutesAttempt1']) ? $user['accountabilityAddMinutesAttempt1'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>Accountability Add Minutes Attempt 2</label>
                        <input class="form-control" type="text" name="accountabilityAddMinutesAttempt2" value="{{ (isset($user['accountabilityAddMinutesAttempt2']) ? $user['accountabilityAddMinutesAttempt2'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>Accountability Add Minutes Attempt 3</label>
                        <input class="form-control" type="text" name="accountabilityAddMinutesAttempt3" value="{{ (isset($user['accountabilityAddMinutesAttempt3']) ? $user['accountabilityAddMinutesAttempt3'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>Accountability Add Minutes Attemptn</label>
                        <input class="form-control" type="text" name="accountabilityAddMinutesAttemptn" value="{{ (isset($user['accountabilityAddMinutesAttemptn']) ? $user['accountabilityAddMinutesAttemptn'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>Accountability Add Days After Convo</label>
                        <input class="form-control" type="text" name="accountabilityAddDaysAfterConvo" value="{{ (isset($user['accountabilityAddDaysAfterConvo']) ? $user['accountabilityAddDaysAfterConvo'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>Accountability Earliest Required Hour In CST</label>
                        <input class="form-control" type="text" name="accountabilityEarliestRequiredHourInCST" value="{{ (isset($user['accountabilityEarliestRequiredHourInCST']) ? $user['accountabilityEarliestRequiredHourInCST'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>Accountability Latest Required Hour In CST</label>
                        <input class="form-control" type="text" name="accountabilityLatestRequiredHourInCST" value="{{ (isset($user['accountabilityLatestRequiredHourInCST']) ? $user['accountabilityLatestRequiredHourInCST'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>Professional Recommendations Score</label>
                        <input class="form-control" type="text" name="ProfessionalRecommendationsScore" value="{{ (isset($user['ProfessionalRecommendationsScore']) ? $user['ProfessionalRecommendationsScore'] : '' ) }}" />
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Profile</label>
                    <textarea class="form-control" name="Profile" rows="4">{{ (isset($user['Profile']) ? $user['Profile'] : '' ) }}</textarea>
                </div>
                <div class="form-group">
                    <label>Visitor Tracker Code</label>
                    <textarea class="form-control" name="VisitorTrackerCode" rows="4">{{ (isset($user['VisitorTrackerCode']) ? $user['VisitorTrackerCode'] : '' ) }}</textarea>
                </div>
                <div class="form-group">
                    <label>Lead Tracker Code</label>
                    <textarea class="form-control" name="LeadTrackerCode" rows="4">{{ (isset($user['LeadTrackerCode']) ? $user['LeadTrackerCode'] : '' ) }}</textarea>
                </div>
                <div class="form-group">
                    <label>Custom Terms</label>
                    <textarea class="form-control" name="CustomTerms" rows="4">{{ (isset($user['CustomTerms']) ? $user['CustomTerms'] : '' ) }}</textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Landing Page Menu</label>
                    <textarea class="form-control" name="LandingPageMenu" rows="4">{{ (isset($user['LandingPageMenu']) ? $user['LandingPageMenu'] : '' ) }}</textarea>
                </div>
                <div class="form-group">
                    <label>MLS Legal Disclaimer</label>
                    <textarea class="form-control" name="MLSLegalDisclaimer" rows="4">{{ (isset($user['MLSLegalDisclaimer']) ? $user['MLSLegalDisclaimer'] : '' ) }}</textarea>
                </div>
                <div class="form-group">
                    <label>MLS Max Listings PerPage Message</label>
                    <textarea class="form-control" name="MLSMaxListingsPerPageMessage" rows="4">{{ (isset($user['MLSMaxListingsPerPageMessage']) ? $user['MLSMaxListingsPerPageMessage'] : '' ) }}</textarea>
                </div>
                <div class="form-group">
                    <label>MLS Legal Each Listing</label>
                    <textarea class="form-control" name="MLSLegalEachListing" rows="4">{{ (isset($user['MLSLegalEachListing']) ? $user['MLSLegalEachListing'] : '' ) }}</textarea>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="col-md-6">
                <div class="checkbox">
                    <label><input type="checkbox" name="IsClient" value="1" {{ (isset($user['IsClient']) && $user['IsClient'] ? 'checked="checked"' : '' ) }} /> Is Client</label>
                </div>
                <div class="checkbox">
                    <label><input type="checkbox" name="AgreementAccepted" value="1" {{ (isset($user['AgreementAccepted']) && $user['AgreementAccepted'] ? 'checked="checked"' : '' ) }} /> Agreement Accepted</label>
                </div>
                <div class="checkbox">
                    <label><input type="checkbox" name="IsOnGoogle" value="1" {{ (isset($user['IsOnGoogle']) && $user['IsOnGoogle'] ? 'checked="checked"' : '' ) }} /> Is On Google</label>
                </div>
                <div class="checkbox">
                    <label><input type="checkbox" name="IsTest" value="1" {{ (isset($user['IsTest']) && $user['IsTest'] ? 'checked="checked"' : '' ) }} /> Is Test</label>
                </div>
                <div class="checkbox">
                    <label><input type="checkbox" name="HasCancelled" value="1" {{ (isset($user['HasCancelled']) && $user['HasCancelled'] ? 'checked="checked"' : '' ) }} /> Has Cancelled</label>
                </div>
                <div class="checkbox">
                    <label><input type="checkbox" name="PrePaid" value="1" {{ (isset($user['PrePaid']) && $user['PrePaid'] ? 'checked="checked"' : '' ) }} /> PrePaid</label>
                </div>
                <div class="checkbox">
                    <label><input type="checkbox" name="PaidForward" value="1" {{ (isset($user['PaidForward']) && $user['PaidForward'] ? 'checked="checked"' : '' ) }} /> Paid Forward</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="checkbox">
                    <label><input type="checkbox" name="hasReviewed" value="1" {{ (isset($user['hasReviewed']) && $user['hasReviewed'] ? 'checked="checked"' : '' ) }} /> Has Reviewed</label>
                </div>
                <div class="checkbox">
                    <label><input type="checkbox" name="IsOnOscar" value="1" {{ (isset($user['IsOnOscar']) && $user['IsOnOscar'] ? 'checked="checked"' : '' ) }} /> Is On Oscar</label>
                </div>
                <div class="checkbox">
                    <label><input type="checkbox" name="AgreedCustomTerms" value="1" {{ (isset($user['AgreedCustomTerms']) && $user['AgreedCustomTerms'] ? 'checked="checked"' : '' ) }} /> Agreed Custom Terms</label>
                </div>
                <div class="checkbox">
                    <label><input type="checkbox" name="AccountabilityEnabled" value="1" {{ (isset($user['AccountabilityEnabled']) && $user['AccountabilityEnabled'] ? 'checked="checked"' : '' ) }} /> Accountability Enabled</label>
                </div>
                <div class="checkbox">
                    <label><input type="checkbox" name="NeedsMysturyShoppers" value="1" {{ (isset($user['NeedsMysturyShoppers']) && $user['NeedsMysturyShoppers'] ? 'checked="checked"' : '' ) }} /> Needs Mystury Shoppers</label>
                </div>
                <div class="checkbox">
                    <label><input type="checkbox" name="isSuspended" value="1" {{ (isset($user['isSuspended']) && $user['isSuspended'] ? 'checked="checked"' : '' ) }} /> Is Suspended</label>
                </div>
                <div class="checkbox">
                    <label><input type="checkbox" name="isGettingDeployed" value="1" {{ (isset($user['isGettingDeployed']) && $user['isGettingDeployed'] ? 'checked="checked"' : '' ) }} /> Is Getting Deployed</label>
                </div>
                <div class="checkbox">
                    <label><input type="checkbox" name="isLive" value="1" {{ (isset($user['isLive']) && $user['isLive'] ? 'checked="checked"' : '' ) }} /> Is Live</label>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <div class="clearfix"></div>
                <button type="submit" class="btn btn-primary form-submit">Submit</button>
            </div>
        </div>
        @else
            <div class="col-md-12 alert alert-success">
                {{ $created }}
            </div>
        @endif
    </form>
</div>
@stop
@extends('layouts.intranet')
