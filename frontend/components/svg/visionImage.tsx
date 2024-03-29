import React from 'react';
import { twMerge } from 'tailwind-merge';

interface Props {
  className: string;
  imageUrl: string;
  imageId: string;
  flipImage: boolean;
}

const VisionImage: React.FC<Props> = ({
  className,
  imageId,
  imageUrl,
  flipImage,
}) => {
  return (
    <svg
      className={twMerge('w-full h-full', className)}
      xmlns="http://www.w3.org/2000/svg"
      viewBox="0 0 629 649"
      preserveAspectRatio="none"
      fill="none"
      id="visionSvg"
    >
      <defs>
        <pattern
          id={imageId}
          patternUnits="userSpaceOnUse"
          width="100%"
          height="100%"
        >
          <image
            href={imageUrl}
            x="0"
            y="0"
            width="100%"
            height="100%"
            preserveAspectRatio="xMidYMid slice"
            transform={flipImage ? `scale(-1, 1)` : ''}
            transform-origin="center"
          />
        </pattern>
      </defs>
      <path
        d="M119.044 1.4514L1.73437 97.3249C1.2696 97.7048 1 98.2733 1 98.8735V646C1 647.105 1.89544 648 3 648H515.337C515.779 648 516.209 647.853 516.559 647.583L627.222 562.167C627.713 561.789 628 561.204 628 560.584V3C628 1.89543 627.105 1 626 1H120.309C119.848 1 119.401 1.15948 119.044 1.4514Z"
        stroke="#74777F"
        fill={`url(#${imageId})`}
      />
    </svg>
  );
};

export default VisionImage;
