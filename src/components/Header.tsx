const Header = () => {
    return (
        <>
            <header className="relative flex justify-between items-center px-8 py-6 bg-[#156064]/95 shadow-lg text-white overflow-hidden backdrop-blur-sm">
                {/* Subtle background accent */}
                <div className="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-[#03CEA4] via-[#FEFFA5] to-[#03CEA4]"></div>
                
                {/* Logo with natural yellow highlight */}
                <div className="relative z-10">
                    <h1 className="text-3xl font-black text-[#FEFFA5] hover:scale-105 transition-all duration-300 cursor-pointer drop-shadow-lg">
                        Zenleaf
                    </h1>
                </div>
                
                {/* Clean navigation */}
                <nav className="relative z-10">
                    <ul className="flex space-x-8">
                        <li>
                            <a
                                href="#home"
                                className="relative font-semibold text-white/90 hover:text-[#03CEA4] transition-all duration-300 group px-3 py-2 rounded-lg hover:bg-[#03CEA4]/10"
                            >
                                Home
                                <span className="absolute bottom-0 left-0 w-0 h-0.5 bg-[#03CEA4] group-hover:w-full transition-all duration-300"></span>
                            </a>
                        </li>
                        <li>
                            <a
                                href="#about"
                                className="relative font-semibold text-white/90 hover:text-[#03CEA4] transition-all duration-300 group px-3 py-2 rounded-lg hover:bg-[#03CEA4]/10"
                            >
                                About
                                <span className="absolute bottom-0 left-0 w-0 h-0.5 bg-[#03CEA4] group-hover:w-full transition-all duration-300"></span>
                            </a>
                        </li>
                        <li>
                            <a
                                href="#products"
                                className="relative font-semibold text-white/90 hover:text-[#03CEA4] transition-all duration-300 group px-3 py-2 rounded-lg hover:bg-[#03CEA4]/10"
                            >
                                Products
                                <span className="absolute bottom-0 left-0 w-0 h-0.5 bg-[#03CEA4] group-hover:w-full transition-all duration-300"></span>
                            </a>
                        </li>
                        <li>
                            <a
                                href="#blog"
                                className="relative font-semibold text-white/90 hover:text-[#03CEA4] transition-all duration-300 group px-3 py-2 rounded-lg hover:bg-[#03CEA4]/10"
                            >
                                Blog
                                <span className="absolute bottom-0 left-0 w-0 h-0.5 bg-[#03CEA4] group-hover:w-full transition-all duration-300"></span>
                            </a>
                        </li>
                        <li>
                            <a
                                href="#contact"
                                className="relative font-semibold text-white/90 hover:text-[#03CEA4] transition-all duration-300 group px-3 py-2 rounded-lg hover:bg-[#03CEA4]/10"
                            >
                                Contact
                                <span className="absolute bottom-0 left-0 w-0 h-0.5 bg-[#03CEA4] group-hover:w-full transition-all duration-300"></span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </header>
        </>
    );
};

export default Header;
