<div style="background-color: lightcyan; height: 100vh; width: 100%; padding-top: 40px;">
    <div style="text-align: left; margin: 0 auto; width: 450px; height: auto; background-color:white;padding: 8px;">
        <h2 style="text-align: center;">Covax Portal</h2>
        <h5>
            Dear {{ $user->name }},
            <br />
            On {{ \Carbon\Carbon::parse($scheduleDate)->format('d-m-Y') ; }} at 10 AM, please stay at your selected venue for Vaccination.
            <br />
            <br />
            Regards
            <br />
            Vaccine Team
        </h5>
    </div>
</div>