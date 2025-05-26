<x-app-layout>
    <Section class="banner-sec inner-banner">
        <div class="container">
            <div class="inner-content">
                <h2>Events Gallery</h2>
                <p>Explore Our Visual Stories – A Journey Through Moments Captured in Time</p>
            </div>
        </div>
    </Section>
    <section class="gallery-sec common-spacing" id="gallery">
        <div class="container mx-auto">
            <div class="tab-wrapper" data-tab-wrapper="gallery">
            <div class="flex justify-center winners-main items-center mb-6">
                <div class="item">
                    <div class="flex gap-4">
                        <div class="tab-item">
                            <a href="" class="tab-link justify-center active" data-tab="gallery-2024">2024</a>
                        </div>
                        <div class="tab-item">
                            <a href="" class="tab-link justify-center" data-tab="gallery-2023">2023</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-content">
                <div class="tab-panel" data-tab="gallery-2024">
                    <div class="item">
                        <div class="sub-title mb-6 text-center">National Automobile Olympiad (NAO 2024), held in Bhopal</div>
                    </div>
                    <div class="gallery-zig">
                      <article class="gallery__item">
                        <img src="{{ asset('/images/gallery2024-1.webp') }}" alt="Fearless leader" width="800" height="534" />
                      </article>
                      <article class="gallery__item">
                        <img src="{{ asset('/images/gallery2024-2.webp') }}" alt="Southbank - Strike a Pose" width="800" height="534" />
                      </article>
                      <article class="gallery__item">
                        <img src="{{ asset('/images/gallery2024-3.webp') }}" alt="Tower Bridge, light trails" width="800" height="534" />
                      </article>
                      <article class="gallery__item">
                        <img src="{{ asset('/images/gallery2024-4.webp') }}" alt="The Clyde Arc" width="800" height="534" />
                      </article>
                      <article class="gallery__item">
                        <img src="{{ asset('/images/gallery2024-5.webp') }}" alt="Reflections at St Pauls" width="800" height="534" />
                      </article>
                      <article class="gallery__item">
                        <img src="{{ asset('/images/gallery2024-6.webp') }}" alt="Fearless leader" width="800" height="534" />
                      </article>
                      <article class="gallery__item">
                        <img src="{{ asset('/images/gallery2024-8.webp') }}" alt="Southbank - Strike a Pose" width="800" height="534" />
                      </article>
                      <article class="gallery__item">
                        <img src="{{ asset('/images/gallery2024-7.webp') }}" alt="Tower Bridge, light trails" width="800" height="534" />
                      </article>
                      <article class="gallery__item">
                        <img src="{{ asset('/images/gallery2024-9.webp') }}" alt="The Clyde Arc" width="800" height="534" />
                      </article>
                      <article class="gallery__item">
                        <img src="{{ asset('/images/gallery2024-10.webp') }}" alt="Reflections at St Pauls" width="800" height="534" />
                      </article>
                    

                    </div>
                </div>
                <div class="tab-panel hidden" data-tab="gallery-2023">
                    <div class="item">
                        <div class="sub-title mb-6 text-center">National Automobile Olympiad (NAO 2023), held in Ghaziabad</div>
                    </div>
                    <div class="gallery-zig">
                      <article class="gallery__item">
                        <img src="{{ asset('/images/nao-6.jpg') }}" alt="Fearless leader" width="800" height="534" />
                      </article>
                      <article class="gallery__item">
                        <img src="{{ asset('/images/nao-11.jpg') }}" alt="Southbank - Strike a Pose" width="800" height="534" />
                      </article>
                      <article class="gallery__item">
                        <img src="{{ asset('/images/nao-1.jpg') }}" alt="Tower Bridge, light trails" width="800" height="534" />
                      </article>
                      <article class="gallery__item">
                        <img src="{{ asset('/images/nao2.jpg') }}" alt="The Clyde Arc" width="800" height="534" />
                      </article>
                      <article class="gallery__item">
                        <img src="{{ asset('/images/nao-7.jpg') }}" alt="Reflections at St Pauls" width="800" height="534" />
                      </article>
                      <article class="gallery__item">
                        <img src="{{ asset('/images/gallery2023-1.webp') }}" alt="Fearless leader" width="800" height="534" />
                      </article>
                      <article class="gallery__item">
                        <img src="{{ asset('/images/gallery2023-2.webp') }}" alt="Southbank - Strike a Pose" width="800" height="534" />
                      </article>
                      <article class="gallery__item">
                        <img src="{{ asset('/images/gallery2023-3.webp') }}" alt="Tower Bridge, light trails" width="800" height="534" />
                      </article>
                      <article class="gallery__item">
                        <img src="{{ asset('/images/gallery2023-4.webp') }}" alt="The Clyde Arc" width="800" height="534" />
                      </article>
                      <article class="gallery__item">
                        <img src="{{ asset('/images/gallery2023-5.webp') }}" alt="Reflections at St Pauls" width="800" height="534" />
                      </article>
                </div>
                </div>
            </div>
        </div>
        </div>
      </section>
      <section class="sponser-sec" id="sponsors">
        <div class="container">
            <div class="common-title text-center mb-6">Our <span>Sponsors</span></div>
            <div class="SecPartnerContent SecSupportedBy">
                <div class="rowDiv">
                    <div class="col-50">
                        <div class="sub-title text-center">Gold Sponsors</div>
                        <ul>
                            <li>
                                <div class="imgWrap"><img src="{{ asset('/images/logo4.webp') }}" alt="Sansera Idea work" width="218" height="120">
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-50">
                        <div class="sub-title text-center">Silver Sponsors</div>
                        <ul>
                            <li>
                                <div class="imgWrap"><img src="{{ asset('/images/mgu.webp') }}" alt="MGU" width="218" height="120">
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-50">
                        <div class="sub-title text-center">NAO Partner</div>
                        <ul>
                            <li>
                                <div class="imgWrap"><img src="{{ asset('/images/logo5.webp') }}" alt="Humming Bird" width="218" height="120">
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
        </div>
    </section>
    
</x-app-layout>