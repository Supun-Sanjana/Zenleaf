
const Hero = () => {
  return (
    <div>
      <section className="relative min-h-screen flex items-center justify-center overflow-hidden">
        
        {/* Background gradient */}
        <div className="absolute inset-0 bg-gradient-to-br from-green-600 via-green-700 to-green-800 hero-pattern filter blur-lg"></div>

        {/* Floating animated blobs */}
        <div className="absolute inset-0 overflow-hidden">
          <div className="absolute top-1/4 left-1/4 w-64 h-64 bg-white/10 rounded-full blur-3xl animate-bounce-slow"></div>
          <div 
            className="absolute bottom-1/4 right-1/4 w-96 h-96 bg-green-400/20 rounded-full blur-3xl animate-bounce-slow" 
            style={{ animationDelay: '1s' }}
          ></div>
          <div 
            className="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-32 h-32 bg-white/5 rounded-full blur-2xl animate-bounce-slow" 
            style={{ animationDelay: '2s' }}
          ></div>
        </div>

        {/* Foreground content */}
        <div className="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
          <div className="animate-fade-in">
            
            {/* Main Heading */}
            <h1 className="text-4xl md:text-6xl lg:text-7xl font-bold text-white mb-6 leading-tight animate-slide-up">
              Premium 
              <span className="bg-gradient-to-r from-white via-green-300 to-green-400 bg-clip-text text-transparent animate-pulse">
                Bonsai Collection
              </span>
            </h1>

            {/* Subtitle */}
            <p 
              className="text-lg md:text-xl lg:text-2xl text-white/90 mb-8 max-w-4xl mx-auto leading-relaxed animate-slide-up" 
              style={{ animationDelay: '0.2s' }}
            >
              Discover the art of{' '}
              <span className="font-semibold text-green-300">miniature gardening</span>{' '}
              with our carefully curated collection of bonsai trees, accessories, and expert care guides.
            </p>

            {/* CTA Buttons */}
            <div 
              className="flex flex-col sm:flex-row gap-4 justify-center items-center animate-slide-up" 
              style={{ animationDelay: '0.4s' }}
            >
              <a 
                href="#products" 
                className="group inline-flex items-center px-8 py-4 text-lg font-semibold text-white bg-green-600 hover:bg-green-700 rounded-full shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300 focus:ring-4 focus:ring-green-300"
              >
                <span>Shop Now</span>
                <i className="fas fa-shopping-cart ml-2 group-hover:translate-x-1 transition-transform duration-200"></i>
              </a>
              
              <a 
                href="#about" 
                className="group inline-flex items-center px-8 py-4 text-lg font-semibold text-white bg-white/20 hover:bg-white/30 rounded-full backdrop-blur-sm border border-white/30 hover:border-white/50 transform hover:scale-105 transition-all duration-300 focus:ring-4 focus:ring-white/25"
              >
                <i className="fas fa-seedling mr-2 group-hover:scale-110 transition-transform duration-200"></i>
                <span>Learn More</span>
              </a>
            </div>

            {/* Stats Grid */}
            <div 
              className="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8 animate-slide-up" 
              style={{ animationDelay: '0.6s' }}
            >
              <div className="glass-effect rounded-2xl p-6 text-center">
                <div className="text-3xl font-bold text-white mb-2">500+</div>
                <div className="text-white/80">Happy Customers</div>
              </div>
              <div className="glass-effect rounded-2xl p-6 text-center">
                <div className="text-3xl font-bold text-white mb-2">100+</div>
                <div className="text-white/80">Bonsai Varieties</div>
              </div>
              <div className="glass-effect rounded-2xl p-6 text-center">
                <div className="text-3xl font-bold text-white mb-2">15+</div>
                <div className="text-white/80">Years Experience</div>
              </div>
            </div>
          </div>
        </div>

        {/* Scroll indicator */}
        <div className="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
          <a 
            href="#products" 
            className="text-white/70 hover:text-white transition-colors duration-200"
          >
            <i className="fas fa-chevron-down text-2xl"></i>
          </a>
        </div>
      </section>
    </div>
  );
};


export default Hero