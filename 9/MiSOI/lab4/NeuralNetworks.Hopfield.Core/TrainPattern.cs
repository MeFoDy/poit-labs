namespace NeuralNetworks.Hopfield.Core
{
    public class TrainPattern : ImageUnit
    {
        public TrainPattern()
        {
        }

        public TrainPattern(ImageUnit unit)
        {
            Id = unit.Id;
            Image = unit.Image;
        }

        public bool[] BinarizedRepresentation { get; set; }
    }
}
