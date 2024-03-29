import {
  config,
  useChain,
  useSpring,
  useTransition,
  type Lookup,
  type SpringRef,
  type SpringValue,
  type TransitionFn,
} from '@react-spring/web';

interface Props<T> {
  activeTrigger: boolean;
  springRef: SpringRef<Lookup<any>>;
  transRef: SpringRef<Lookup<any>>;
  list: T[];
  sizeType: 'rem' | 'vh' | '%';
}

interface Animation<T> {
  transitions: TransitionFn<
    T,
    {
      opacity: number;
      scale: number;
      y: number;
    }
  >;
  size: SpringValue<string>;
  rest: any;
}

function useShowListAnim<T>({
  activeTrigger,
  springRef,
  transRef,
  list,
  sizeType = '%',
}: Props<T>): Animation<T> {
  const { size, ...rest } = useSpring({
    ref: springRef,
    from: { size: `0${sizeType}` },
    to: { size: activeTrigger ? `100${sizeType}` : `0${sizeType}` },
    config: { ...config.gentle, duration: 100 },
  });

  const data = list;
  const transitions = useTransition(activeTrigger ? data : [], {
    ref: transRef,
    trail: 300 / data.length,
    from: { opacity: 0, scale: 0, y: 0 },
    enter: { opacity: 1, scale: 1, y: 1 },
    leave: { opacity: 0, scale: 0, y: 0 },
  });

  useChain(activeTrigger ? [springRef, transRef] : [transRef, springRef], [
    0,
    activeTrigger ? 0.1 : 1,
  ]);

  return { size, rest, transitions };
}
export default useShowListAnim;
