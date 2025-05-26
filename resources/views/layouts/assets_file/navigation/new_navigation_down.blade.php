 </ul>
            
          </nav>
          <!--<div class="">-->
          <!--    <a herf=""  ><img src="images/search-ico.svg" width="25" height="25" ></a>-->
          <!--</div>-->
          
          <div class="right-menu flex gap-4">
            <div class="relative item">
                <!-- Trigger Button -->
                <a href="javarscript:void();" class="common-btn flex items-center registration-btn">
                    Registration
                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                    </svg>
                </a>
          
                <!-- Dropdown Menu -->
                <div id="dropdownMenu" class="hidden dropdown-menu">
                    <a href="{{ route('school_register') }}" class="flex items-center px-4 py-2">
                        <img src="{{ asset('/images/school-ico.svg') }}" alt="School" class="mr-2"/>
                        For School
                    </a>
                    <a href="{{ route('register') }}" class="flex items-center px-4 py-2">
                        <img src="{{ asset('/images/student-ico.svg') }}" alt="Student" class="mr-2"/>
                        For Student
                    </a>
                </div>
            </div>
            <div class="item">
                <a href="{{ route('login') }}" class="login-btn">Login</a>
            </div>
        </div>
        <button 
        class="lg:hidden flex flex-col justify-between h-6 w-8 focus:outline-none toggle-menu" 
        @click="open = !open" 
        aria-label="Toggle Menu"
      >
        <span class="block h-1 w-full bg-gray-800 rounded"></span>
        <span class="block h-1 w-full bg-gray-800 rounded"></span>
        <span class="block h-1 w-full bg-gray-800 rounded"></span>
      </button>
        </div>
        </div>
        
        
        <!--<div class="search-box-input">-->
        <!--  <div class="input-field">-->
        <!--       <button type="button" ><img src="images/search-ico.svg" width="25" height="25" ></button>-->
        <!--       <input type="text" placeholder="Search here..." />-->
        <!--       <div class="search-closed">x</div>-->
        <!--  </div>-->
        <!--</div>-->
        
      </header>
      
      
      