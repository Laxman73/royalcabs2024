<!DOCTYPE html>
<html>
<head>
    <title>Pine Labs Payment Gateway Integration</title>
</head>
<body>
    <h2>Payment Details</h2>
    <form action="process_payment.php" method="post">
        <label for="amount">Amount:</label>
        <input type="text" name="amount" required><br>
        <!-- Include other required payment fields like card number, expiry, CVV, etc. -->
        <button type="submit">Proceed to Payment</button>
    </form>
    <script>
        const options = {
  method: 'POST',
  headers: {
    'x-verify': 'CE34A3A316ED83B8A5B00C17906DF8DAF2436AB25841E844B49F5E0B4BBB1E3E',
    'content-type': 'application/json'
  },
  body: JSON.stringify('{"request": "ewogICJtZXJjaGFudF9kYXRhIjogewogICAgIm1lcmNoYW50X2lkIjogIjMwMDAwMDQiLAogICAgIm1lcmNoYW50X2FjY2Vzc19jb2RlIjogImUwZGE3Mzk1LTllNWEtNDhkMS1iMDExLTAxMjdlYzk1MWUiLAogICAgIm1lcmNoYW50X3JldHVybl91cmwiOiAiaHR0cDovLzEwLjIwOC44LjEzOTo5MDIwL2NoYXJnaW5ncmVzcG5ldy5hc3B4IiwKICAgICJtZXJjaGFudF9vcmRlcl9pZCI6ICJmZWIxMzAxIgogIH0sCiAgInBheW1lbnRfaW5mb19kYXRhIjogewogICAgImFtb3VudCI6IDEwMCwKICAgICJjdXJyZW5jeV9jb2RlIjogIklOUiIsCiAgICAib3JkZXJfZGVzYyI6ICJUZXN0IFN1YnNjcmlwdGlvbiBPcmRlciBjcmVhdGlvbiIKICB9LAogICJjdXN0b21lcl9kYXRhIjogewogICAgImNvdW50cnlfY29kZSI6ICI5MSIsCiAgICAibW9iaWxlX251bWJlciI6ICI5NDQ0NjAwNjkzIiwKICAgICJlbWFpbF9pZCI6ICJrLmRoYWtzaGluYW1vb3J0aHlAcGluZWxhYnMuY29tIgogIH0sCiAgImJpbGxpbmdfYWRkcmVzc19kYXRhIjogewogICAgImZpcnN0X25hbWUiOiAiRGhha3NoaW4iLAogICAgImxhc3RfbmFtZSI6ICJLcmlzaCIsCiAgICAiYWRkcmVzczEiOiAiQ2hlbm5haSIsCiAgICAiYWRkcmVzczIiOiAiQ2hlbm5haSIsCiAgICAiYWRkcmVzczMiOiAiQ2hlbm5haSIsCiAgICAicGluX2NvZGUiOiAiNjAwMDA0IiwKICAgICJjaXR5IjogIkNoZW5uYWkiLAogICAgInN0YXRlIjogIlRhbWlsTmFkdSIsCiAgICAiY291bnRyeSI6ICJJbmRpYSIKICB9LAogICJzaGlwcGluZ19hZGRyZXNzX2RhdGEiOiB7CiAgICAiZmlyc3RfbmFtZSI6ICJEaGFrc2hpbiIsCiAgICAibGFzdF9uYW1lIjogIktyaXNoIiwKICAgICJhZGRyZXNzMSI6ICJDaGVubmFpIiwKICAgICJhZGRyZXNzMiI6ICJDaGVubmFpIiwKICAgICJhZGRyZXNzMyI6ICJDaGVubmFpIiwKICAgICJwaW5fY29kZSI6ICI2MDAwMDQiLAogICAgImNpdHkiOiAiQ2hlbm5haSIsCiAgICAic3RhdGUiOiAiVGFtaWxOYWR1IiwKICAgICJjb3VudHJ5IjogIkluZGlhIgogIH0sCiAgInByb2R1Y3RfaW5mb19kYXRhIjogewogICAgInByb2R1Y3RfZGV0YWlscyI6IFsKICAgICAgewogICAgICAgICJwcm9kdWN0X2NvZGUiOiAidGVzdCIsCiAgICAgICAgInByb2R1Y3RfYW1vdW50IjogMTAwCiAgICAgIH0KICAgIF0KICB9LAogICJhZGRpdGlvbmFsX2luZm9fZGF0YSI6IHsKICAgICJyZnUxIjogIiIsCiAgICAicmZ1MiI6ICIiLAogICAgInJmdTMiOiAiIiwKICAgICJyZnU0IjogIiIsCiAgICAicmZ1NSI6ICIiCiAgfSwKICAidHB2X2RhdGEiOiB7CiAgICAiYWNjb3VudF9udW1iZXIiOiAiIgogIH0sCiAgInN1YnNjcmlwdGlvbl9kYXRhIjogewogICAgInBsYW5fZGV0YWlscyI6IHsKICAgICAgIm1lcmNoYW50SWQiOiAiMzAwNCIsCiAgICAgICJzdGFydERhdGUiOiAiMjAyMy0wMi0xM1QxODozMDowMFoiLAogICAgICAiZW5kRGF0ZSI6ICIyMDIzLTAyLTE1VDE4OjMwOjAwWiIsCiAgICAgICJwbGFuIjogewogICAgICAgICJwbGFuSWQiOiAiMTAwIgogICAgICB9CiAgICB9CiAgfSwKICAicGF5bWVudF9jYXRlZ29yeV90eXBlIjogIlJFQ1VSUkFOQ0UiCn0=" }\'')
};

fetch('https://api-staging.pluralonline.com/api/v1/order/create', options)
  .then(response => response.json())
  .then(response => console.log(response))
  .catch(err => console.error(err));
    </script>
</body>
</html>
