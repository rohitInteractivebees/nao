<div class="py-2 top-header">
    <div class="container mx-auto">
        <ul class="flex items-center gap-4 text-white lg:justify-end">
            <li><a href="https://support.asdc.org.in/guest/openticket#" target="_blank">Support</a></li>
            <li><a href="https://nao.asdc.org.in/notice">Notice</a></li>
            <!--<li><a href="https://nao.asdc.org.in/sampleCsv/sample_paper.pdf" target="_blank">Sample Paper</a></li>-->
        </ul>
        <div id="google_translate_element"></div>
    </div>
</div>
<header class="w-full bg-white d" x-data="{ open: false }">
    <div class="container flex items-center justify-between py-4 mx-auto">
      <!-- Logo -->
      <a href="{{url('')}}" aria-label="NAO" class="flex items-center logo-img">
        <img src="{{ asset('/images/nao-logo-new.png') }}" alt="Logo" class="w-full" width="178" height="100">
      </a>
  <div class="flex items-center gap-4 right-nav">
      <!-- Toggle button for mobile -->

      <!-- Navigation -->
      <nav class="navigation">
        <ul class="flex flex-col lg:flex-row lg:gap-4 lg:items-center">
