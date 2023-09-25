import { type About } from '@/interface';
import AboutBigLine from '../svg/aboutBigLine';
import AboutHero from '../svg/aboutHero';
import AboutHeroCircle from '../svg/aboutHeroCircles';
import AboutHeroLines from '../svg/aboutHeroLines';
import AboutHeroSquares from '../svg/aboutHeroSquares';
import MaskedImageBL from '../svg/maskedImageBL';
import MaskedImageTR from '../svg/maskedImageTR';

interface Props {
  aboutData: About;
}

function Hero({ aboutData }: Props) {
  return (
    <section className="h-screen relative md:mx-xl xs:mx-xs flex md:justify-between xs:justify-normal xs:gap-8 items-center md:flex-row xs:flex-col">
      <div className="md:mt-10 xs:mt-20 z-[2]">
        <h1 className="md:max-w-[48.625rem] mb-xs font-bold md:text-desktop-display xs:text-mobile-headline">
          {aboutData.data.hero_title}
        </h1>

        <p className="md:max-w-[34.5625rem] md:text-desktop-body-large xs:text-mobile-body">
          {aboutData.data.hero_desc}
        </p>
      </div>

      <AboutBigLine className="absolute top-0 md:left-[50%] md:mx-0 xs:mx-auto" />
      <div className="relative md:mr-0 xs:mr-4 md:ml-0 xs:ml-12 w-fit h-fit">
        <AboutHero
          imageUrl={aboutData.data.hero_image}
          className="md:w-[20rem] xs:w-full md:max-h-full xs:max-h-[20.94381rem] relative z-[2]"
        />

        <div className="absolute top-7 -left-[3rem]">
          <AboutHeroLines className="md:h-[15.718rem] xs:h-[12.5rem] md:scale-100 xs:scale-[85%]" />
          <div className="relative">
            <AboutHeroCircle className="absolute top-0" />
            <AboutHeroCircle className="absolute bottom-8 right-8" />
            <AboutHeroCircle className="absolute bottom-14 left-1 md:left-0" />
          </div>
        </div>

        <div className="absolute -top-4 -right-4 flex">
          <AboutHeroSquares className="" />
          <MaskedImageTR className="" />
        </div>
        <MaskedImageBL className="absolute -bottom-4 -left-4" />
      </div>
    </section>
  );
}

export default Hero;
